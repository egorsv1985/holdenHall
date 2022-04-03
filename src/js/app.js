import * as flsFunctions from "./modules/functions.js";

flsFunctions.isWebp();
flsFunctions.bodyLockStatus();
flsFunctions.bodyLockToggle();
flsFunctions.bodyUnlock();
flsFunctions.bodyLock();
flsFunctions.menuInit();
flsFunctions.menuOpen();
flsFunctions.menuClose();



// core version + navigation, pagination modules:
import Swiper, {
	Navigation,
	Pagination
} from 'swiper';

// init Swiper:
const swiper = new Swiper();

// Вспомогательные модули блокировки прокрутки и скочка ====================================================================================================================================================================================================================================================================================
// export let bodyLockStatus = true;
// export let bodyLockToggle = (delay = 500) => {
// 	if (document.documentElement.classList.contains('lock')) {
// 		bodyUnlock(delay);
// 	} else {
// 		bodyLock(delay);
// 	}
// }
// export let bodyUnlock = (delay = 500) => {
// 	let body = document.querySelector("body");
// 	if (bodyLockStatus) {
// 		let lock_padding = document.querySelectorAll("[data-lp]");
// 		setTimeout(() => {
// 			for (let index = 0; index < lock_padding.length; index++) {
// 				const el = lock_padding[index];
// 				el.style.paddingRight = '0px';
// 			}
// 			body.style.paddingRight = '0px';
// 			document.documentElement.classList.remove("lock");
// 		}, delay);
// 		bodyLockStatus = false;
// 		setTimeout(function () {
// 			bodyLockStatus = true;
// 		}, delay);
// 	}
// }
// export let bodyLock = (delay = 500) => {
// 	let body = document.querySelector("body");
// 	if (bodyLockStatus) {
// 		let lock_padding = document.querySelectorAll("[data-lp]");
// 		for (let index = 0; index < lock_padding.length; index++) {
// 			const el = lock_padding[index];
// 			el.style.paddingRight = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';
// 		}
// 		body.style.paddingRight = window.innerWidth - document.querySelector('.wrapper').offsetWidth + 'px';
// 		document.documentElement.classList.add("lock");

// 		bodyLockStatus = false;
// 		setTimeout(function () {
// 			bodyLockStatus = true;
// 		}, delay);
// 	}
// }

// Модуль работы с меню (бургер) =======================================================================================================================================================================================================================
// export function menuInit() {
// 	let iconMenu = document.querySelector(".icon-menu");
// 	if (iconMenu) {
// 		iconMenu.addEventListener("click", function (e) {
// 			if (bodyLockStatus) {
// 				bodyLockToggle();
// 				document.documentElement.classList.toggle("drop-down--open");
// 			}
// 		});
// 	};
// }
// export function menuOpen() {
// 	bodyLock();
// 	document.documentElement.classList.add("drop-down--open");
// }
// export function menuClose() {
// 	bodyUnlock();
// 	document.documentElement.classList.remove("drop-down--open");
// }

// menuInit();