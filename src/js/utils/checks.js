
/**
 *
 */

import config from './config'

export const isMobileViewport = () => window.innerWidth < config.breakpoints.mobile

export const isTabletViewport = () => window.innerWidth >= config.breakpoints.tablet

export const isLaptopViewport = () => window.innerWidth >= config.breakpoints.laptop

export const isHomePage = () => (document.querySelector('[data-page="home"]'))
