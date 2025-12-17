(function ($) {
    "use strict";

    const STRENGTH_CLASSES = ["poor-active", "avg-active", "strong-active", "heavy-active"];
    const BAR_ORDER = ["poor", "weak", "strong", "heavy"];

    const REGEX_RULES = {
        lettersOnly: /^[a-zA-Z]+$/,
        digitsOnly: /^[0-9]+$/
    };

    const LEVEL_CONFIG = {
        poor: {
            className: "poor-active",
            color: "#FF0000",
            message: "Weak. Only letters or only digits detected."
        },
        weak: {
            className: "avg-active",
            color: "#FFB54A",
            message: "Average. Include both letters and numbers."
        },
        strong: {
            className: "strong-active",
            color: "#ffc106",
            message: "Almost. Add a special character and ensure at least 8 characters."
        },
        heavy: {
            className: "heavy-active",
            color: "#159F46",
            message: "OK! The requirement of password is fulfilled."
        },
        invalid: {
            className: "",
            color: "#FF0000",
            message: "Whitespaces are not allowed."
        }
    };

    $(function () {
        initPasswordStrength({
            containerSelector: "#passwordInput",
            strengthSelector: "#passwordStrength",
            infoSelector: "#passwordInfo",
            passcheckSelector: "#passwordInput .pass-checked",
            barSelectors: {
                poor: "#passwordStrength #poor",
                weak: "#passwordStrength #weak",
                strong: "#passwordStrength #strong",
                heavy: "#passwordStrength #heavy"
            }
        });

        initPasswordStrength({
            containerSelector: "#passwordInputs",
            strengthSelector: "#passwordStrengths",
            infoSelector: "#passwordInfos",
            passcheckSelector: "#passwordInputs .pass-checked",
            barSelectors: {
                poor: "#passwordStrengths #poors",
                weak: "#passwordStrengths #weaks",
                strong: "#passwordStrengths #strongs",
                heavy: "#passwordStrengths #heavys"
            }
        });
    });

    function initPasswordStrength({
        containerSelector,
        strengthSelector,
        infoSelector,
        passcheckSelector,
        barSelectors
    }) {
        const container = document.querySelector(containerSelector);
        if (!container) {
            return;
        }

        const passwordInput = container.querySelector('input[type="password"]');
        const strengthElement = document.querySelector(strengthSelector);
        const infoElement = document.querySelector(infoSelector);
        const passcheckElement = passcheckSelector ? document.querySelector(passcheckSelector) : null;
        const bars = Object.fromEntries(
            Object.entries(barSelectors).map(([key, selector]) => [key, document.querySelector(selector)])
        );

        if (!passwordInput || !strengthElement || !infoElement) {
            return;
        }

        passwordInput.addEventListener("input", () => {
            const value = passwordInput.value;

            if (!value) {
                resetUI(strengthElement, infoElement, passcheckElement, bars);
                return;
            }

            strengthElement.style.display = "flex";
            infoElement.style.display = "block";

            const evaluation = evaluatePassword(value);

            if (evaluation.type === "invalid") {
                applyInvalidState(strengthElement, infoElement, passcheckElement, bars);
                updateInfo(infoElement, evaluation);
                return;
            }

            applyStrengthState(strengthElement, passcheckElement, bars, evaluation);
            updateInfo(infoElement, evaluation);
        });
    }

    function evaluatePassword(password) {
        if (/\s/.test(password)) {
            return { type: "invalid", ...LEVEL_CONFIG.invalid };
        }

        const length = password.length;
        const hasLower = /[a-z]/.test(password);
        const hasUpper = /[A-Z]/.test(password);
        const hasLetter = hasLower || hasUpper;
        const hasDigit = /\d/.test(password);
        const hasSymbol = /[.#?!@$%^&*-]/.test(password);

        if (hasLower && hasUpper && hasDigit && hasSymbol && length >= 8) {
            return { type: "heavy", ...LEVEL_CONFIG.heavy };
        }

        if (hasLower && hasUpper && hasDigit) {
            return { type: "strong", ...LEVEL_CONFIG.strong };
        }

        if (hasLetter && hasDigit) {
            return { type: "weak", ...LEVEL_CONFIG.weak };
        }

        if (REGEX_RULES.lettersOnly.test(password) || REGEX_RULES.digitsOnly.test(password)) {
            return { type: "poor", ...LEVEL_CONFIG.poor };
        }

        return { type: "poor", ...LEVEL_CONFIG.poor };
    }

    function applyStrengthState(strengthElement, passcheckElement, bars, evaluation) {
        clearStrengthClasses(strengthElement, bars);

        const currentIndex = BAR_ORDER.indexOf(evaluation.type);
        BAR_ORDER.forEach((key, index) => {
            const bar = bars[key];
            if (!bar) {
                return;
            }
            if (index <= currentIndex) {
                bar.classList.add("active");
            } else {
                bar.classList.remove("active");
            }
        });

        if (evaluation.className) {
            strengthElement.classList.add(evaluation.className);
        }

        if (passcheckElement) {
            passcheckElement.classList.toggle("active", evaluation.type === "heavy");
        }
    }

    function applyInvalidState(strengthElement, infoElement, passcheckElement, bars) {
        clearStrengthClasses(strengthElement, bars);
        if (passcheckElement) {
            passcheckElement.classList.remove("active");
        }
        Object.values(bars).forEach((bar) => {
            if (bar) {
                bar.classList.remove("active");
            }
        });
        strengthElement.classList.remove("poor-active", "avg-active", "strong-active", "heavy-active");
        infoElement.style.display = "block";
    }

    function clearStrengthClasses(strengthElement, bars) {
        STRENGTH_CLASSES.forEach((className) => strengthElement.classList.remove(className));
        Object.values(bars).forEach((bar) => {
            if (bar) {
                bar.classList.remove("active");
            }
        });
    }

    function updateInfo(infoElement, evaluation) {
        infoElement.style.color = evaluation.color;
        infoElement.innerHTML = evaluation.message;
    }

    function resetUI(strengthElement, infoElement, passcheckElement, bars) {
        strengthElement.style.display = "none";
        infoElement.style.display = "none";
        clearStrengthClasses(strengthElement, bars);
        if (passcheckElement) {
            passcheckElement.classList.remove("active");
        }
    }

})(jQuery);
