const DEFAULT_THEME = {
  body_bg_color: '#F2F6FA',
  nav_bg_color: '#edf0f0',
  accent_bg_color: '#fefeff',
  text_body_color: '#494949',
  text_secondary_color: '#7a7777',
  text_accent_color: '#DAC5A7',
  border_color: '#6c5d48',
};

const DEFAULT_MEDIA = {
  logo_url: '',
  hero_image_url: '',
  team_image_url: '',
  developer_logo_url: '',
};

export const defaultSiteSettings = {
  site_name: 'Экспертный проект',
  phones: [],
  email: '',
  address_main: '',
  worktime_main: '',
  social: {},
  media: DEFAULT_MEDIA,
  seo: {
    title: 'Экспертный проект',
    description: '',
    keywords: '',
  },
  map: {
    lat: 59.9386,
    lng: 30.3141,
    zoom: 16,
  },
  theme: DEFAULT_THEME,
  og_image_url: '',
};

function isObject(value) {
  return value && typeof value === 'object' && !Array.isArray(value);
}

function normalizeTheme(theme) {
  if (!isObject(theme)) {
    return { ...DEFAULT_THEME };
  }

  return {
    body_bg_color: theme.body_bg_color || DEFAULT_THEME.body_bg_color,
    nav_bg_color: theme.nav_bg_color || DEFAULT_THEME.nav_bg_color,
    accent_bg_color: theme.accent_bg_color || DEFAULT_THEME.accent_bg_color,
    text_body_color: theme.text_body_color || DEFAULT_THEME.text_body_color,
    text_secondary_color: theme.text_secondary_color || DEFAULT_THEME.text_secondary_color,
    text_accent_color: theme.text_accent_color || DEFAULT_THEME.text_accent_color,
    border_color: theme.border_color || DEFAULT_THEME.border_color,
  };
}

function normalizeMedia(media) {
  if (!isObject(media)) {
    return { ...DEFAULT_MEDIA };
  }

  return {
    logo_url: String(media.logo_url || '').trim(),
    hero_image_url: String(media.hero_image_url || '').trim(),
    team_image_url: String(media.team_image_url || '').trim(),
    developer_logo_url: String(media.developer_logo_url || '').trim(),
  };
}

function colorToRgba(color, alpha) {
  const raw = String(color || '').trim();
  const fallback = `rgba(108, 93, 72, ${alpha})`;

  if (!raw.startsWith('#')) {
    return fallback;
  }

  let hex = raw.slice(1);

  if (hex.length === 3) {
    hex = hex
      .split('')
      .map((char) => char + char)
      .join('');
  }

  if (!/^[\da-fA-F]{6}$/.test(hex)) {
    return fallback;
  }

  const red = Number.parseInt(hex.slice(0, 2), 16);
  const green = Number.parseInt(hex.slice(2, 4), 16);
  const blue = Number.parseInt(hex.slice(4, 6), 16);

  return `rgba(${red}, ${green}, ${blue}, ${alpha})`;
}

export function mergeSiteSettings(source = {}) {
  return {
    ...defaultSiteSettings,
    ...source,
    phones: Array.isArray(source.phones) && source.phones.length > 0 ? source.phones : defaultSiteSettings.phones,
    social: isObject(source.social) ? source.social : defaultSiteSettings.social,
    media: normalizeMedia(source.media),
    seo: {
      ...defaultSiteSettings.seo,
      ...(isObject(source.seo) ? source.seo : {}),
    },
    map: {
      ...defaultSiteSettings.map,
      ...(isObject(source.map) ? source.map : {}),
    },
    theme: normalizeTheme(source.theme),
  };
}

export function applyThemeVariables(source) {
  if (typeof document === 'undefined') {
    return;
  }

  const settings = mergeSiteSettings(source);
  const theme = settings.theme;
  const root = document.documentElement;

  const variables = {
    '--bg-color-body': theme.body_bg_color,
    '--bg-color-nav': theme.nav_bg_color,
    '--bg-color-mobile': theme.nav_bg_color,
    '--bg-color-accent': theme.accent_bg_color,
    '--color-text-body': theme.text_body_color,
    '--color-text-secondary': theme.text_secondary_color,
    '--text_color_fon_light': theme.text_accent_color,
    '--border': `0.06rem solid ${theme.border_color}`,
    '--border-default': `0.06rem solid ${colorToRgba(theme.border_color, 0.15)}`,
    '--border-input': `1px solid ${colorToRgba(theme.border_color, 0.2)}`,
  };

  Object.entries(variables).forEach(([name, value]) => {
    root.style.setProperty(name, value);
  });
}