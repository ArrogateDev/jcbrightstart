import isAppleDevice from 'is-apple-device';

if (isAppleDevice(window.navigator)) {
    document.documentElement.classList.add('platform-ios');
}
