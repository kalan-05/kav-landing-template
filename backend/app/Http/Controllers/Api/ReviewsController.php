<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Doctor;
use App\Models\Review;
use App\Support\CaptchaVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ReviewsController extends Controller
{
    public function __construct(
        private readonly CaptchaVerifier $captchaVerifier
    ) {
    }

    public function index(): JsonResponse
    {
        $reviews = Review::query()
            ->published()
            ->with('doctor:id,full_name')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get()
            ->map(static fn (Review $review): array => [
                'id' => $review->id,
                'author_name' => $review->author_name,
                'doctor_name' => optional($review->doctor)->full_name,
                'rating' => $review->rating,
                'text' => $review->text,
                'published_at' => optional($review->published_at)?->toDateString(),
            ])
            ->values();

        return response()->json($reviews);
    }

    public function store(StoreReviewRequest $request): JsonResponse
    {
        if (filled($request->input('website'))) {
            Log::notice('Reviews honeypot triggered', ['ip' => $request->ip()]);

            return response()->json([
                'status' => 'ok',
                'message' => 'РћС‚Р·С‹РІ РїСЂРёРЅСЏС‚ РЅР° РјРѕРґРµСЂР°С†РёСЋ',
            ]);
        }

        if (! $this->passesCaptcha($request)) {
            return response()->json([
                'status' => 'error',
                'message' => $this->captchaVerifier->isConfigured()
                    ? 'РџРѕРґС‚РІРµСЂРґРёС‚Рµ, С‡С‚Рѕ РІС‹ РЅРµ СЂРѕР±РѕС‚.'
                    : 'РљР°РїС‡Р° РІСЂРµРјРµРЅРЅРѕ РЅРµРґРѕСЃС‚СѓРїРЅР°. РћР±СЂР°С‚РёС‚РµСЃСЊ Рє Р°РґРјРёРЅРёСЃС‚СЂР°С‚РѕСЂСѓ.',
            ], $this->captchaVerifier->isConfigured() ? 422 : 503);
        }

        $doctorId = $request->input('doctor_id');
        if (! $doctorId && filled($request->input('doctor_name'))) {
            $doctorId = Doctor::query()
                ->where('full_name', $request->string('doctor_name')->trim()->toString())
                ->value('id');
        }

        $review = $this->createDraftReview(
            authorName: $request->string('author_name')->trim()->toString(),
            rating: (int) $request->input('rating'),
            text: $request->string('text')->trim()->toString(),
            doctorId: $doctorId,
            authorContacts: $request->input('author_contacts'),
            meta: [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );

        $this->notifyAdmin($review);

        return response()->json([
            'status' => 'ok',
            'message' => 'РћС‚Р·С‹РІ РїСЂРёРЅСЏС‚ РЅР° РјРѕРґРµСЂР°С†РёСЋ',
        ]);
    }

    public function legacyStore(Request $request): Response
    {
        if (filled($request->input('antispam'))) {
            Log::notice('Legacy reviews honeypot triggered', ['ip' => $request->ip()]);

            return response('РћР±РЅР°СЂСѓР¶РµРЅР° СЃРїР°Рј-Р°РєС‚РёРІРЅРѕСЃС‚СЊ', 400, [
                'Content-Type' => 'text/plain; charset=UTF-8',
            ]);
        }

        if (! $this->passesCaptcha($request)) {
            return response(
                $this->captchaVerifier->isConfigured()
                    ? 'РџРѕРґС‚РІРµСЂРґРёС‚Рµ, С‡С‚Рѕ РІС‹ РЅРµ СЂРѕР±РѕС‚.'
                    : 'РљР°РїС‡Р° РІСЂРµРјРµРЅРЅРѕ РЅРµРґРѕСЃС‚СѓРїРЅР°. РћР±СЂР°С‚РёС‚РµСЃСЊ Рє Р°РґРјРёРЅРёСЃС‚СЂР°С‚РѕСЂСѓ.',
                $this->captchaVerifier->isConfigured() ? 422 : 503,
                ['Content-Type' => 'text/plain; charset=UTF-8']
            );
        }

        $validator = Validator::make($request->all(), [
            'userName' => ['required', 'string', 'min:2', 'max:120'],
            'doctorSelect' => ['nullable', 'string', 'max:255'],
            'reviewRating' => ['required', 'integer', 'min:1', 'max:5'],
            'reviewText' => ['required', 'string', 'min:10', 'max:4000'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = 'РџСЂРѕРІРµСЂСЊС‚Рµ РєРѕСЂСЂРµРєС‚РЅРѕСЃС‚СЊ Р·Р°РїРѕР»РЅРµРЅРёСЏ С„РѕСЂРјС‹.';

            if ($errors->has('userName')) {
                $message = 'РРјСЏ РґРѕР»Р¶РЅРѕ СЃРѕРґРµСЂР¶Р°С‚СЊ РјРёРЅРёРјСѓРј 2 СЃРёРјРІРѕР»Р°.';
            } elseif ($errors->has('doctorSelect')) {
                $message = 'РџРѕР¶Р°Р»СѓР№СЃС‚Р°, РІС‹Р±РµСЂРёС‚Рµ РєРѕСЂСЂРµРєС‚РЅРѕРіРѕ РІСЂР°С‡Р°.';
            } elseif ($errors->has('reviewRating')) {
                $message = 'РќРµРєРѕСЂСЂРµРєС‚РЅР°СЏ РѕС†РµРЅРєР° (РґРѕРїСѓСЃС‚РёРјРѕ РѕС‚ 1 РґРѕ 5).';
            } elseif ($errors->has('reviewText')) {
                $message = 'РўРµРєСЃС‚ РѕС‚Р·С‹РІР° РґРѕР»Р¶РµРЅ СЃРѕРґРµСЂР¶Р°С‚СЊ РјРёРЅРёРјСѓРј 10 СЃРёРјРІРѕР»РѕРІ.';
            }

            return response($message, 422, [
                'Content-Type' => 'text/plain; charset=UTF-8',
            ]);
        }

        $data = $validator->validated();

        $doctorId = null;
        if (! empty($data['doctorSelect'])) {
            $doctorId = Doctor::query()->where('full_name', $data['doctorSelect'])->value('id');
        }

        $review = $this->createDraftReview(
            authorName: trim((string) $data['userName']),
            rating: (int) $data['reviewRating'],
            text: trim((string) $data['reviewText']),
            doctorId: $doctorId,
            authorContacts: null,
            meta: [
                'legacy' => true,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );

        $this->notifyAdmin($review);

        return response('РЎРїР°СЃРёР±Рѕ! РћС‚Р·С‹РІ РїСЂРёРЅСЏС‚ РЅР° РјРѕРґРµСЂР°С†РёСЋ.', 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    private function passesCaptcha(Request $request): bool
    {
        $candidates = [
            'h-captcha-response',
            'h_captcha_response',
            'captcha_token',
            'g-recaptcha-response',
            'g_recaptcha_response',
        ];

        $token = null;
        foreach ($candidates as $key) {
            $value = $request->input($key);
            if (is_string($value) && trim($value) !== '') {
                $token = trim($value);
                break;
            }
        }

        if ($token === null) {
            Log::warning('Review captcha token missing', [
                'ip' => $request->ip(),
                'keys' => array_keys($request->all()),
            ]);

            return false;
        }

        $isValid = $this->captchaVerifier->verify($token, $request->ip());
        if (! $isValid) {
            Log::warning('Review captcha verification failed', [
                'ip' => $request->ip(),
                'token_length' => mb_strlen($token),
            ]);
        }

        return $isValid;
    }

    private function createDraftReview(
        string $authorName,
        int $rating,
        string $text,
        ?int $doctorId,
        ?string $authorContacts,
        array $meta
    ): Review {
        return Review::query()->create([
            'author_name' => $authorName,
            'rating' => $rating,
            'text' => $text,
            'source' => 'form',
            'status' => 'draft',
            'doctor_id' => $doctorId,
            'author_contacts' => $authorContacts,
            'meta' => $meta,
        ]);
    }

    private function notifyAdmin(Review $review): void
    {
        $recipient = env('REVIEWS_NOTIFY_EMAIL') ?: config('mail.from.address');

        if (! filled($recipient)) {
            return;
        }

        $doctorName = optional($review->doctor)->full_name ?? 'РќРµ СѓРєР°Р·Р°РЅ';
        $body = "РќРѕРІС‹Р№ РѕС‚Р·С‹РІ СЃ СЃР°Р№С‚Р°\n\n"
            . "РђРІС‚РѕСЂ: {$review->author_name}\n"
            . "РћС†РµРЅРєР°: {$review->rating}\n"
            . "Р’СЂР°С‡: {$doctorName}\n"
            . "РўРµРєСЃС‚:\n{$review->text}\n";

        try {
            Mail::raw($body, static function ($message) use ($recipient): void {
                $message
                    ->to($recipient)
                    ->subject('Template: новый отзыв на модерацию');
            });
        } catch (Throwable $e) {
            Log::warning('Failed to send review notification', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}


