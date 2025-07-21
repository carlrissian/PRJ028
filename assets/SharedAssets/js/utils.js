export function getUser() {
    let name = 'auth.user';
    let cookieArr = document.cookie.split(";");

    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");
        if (name == cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
}

/**
 * 
 * @param {*} string 
 * @param {*} lowerRest si se desea poner en minusculas el resto de la cadena. Activo por defecto
 * @returns capitalized string
 */
export function capitalize(string, lowerRest = true, allWords = false) {
    if (allWords && string.includes(' ')) {
        return string.split(' ').map(word => capitalize(word, lowerRest)).join(' ');
    }
    return string.charAt(0).toUpperCase() + (lowerRest ? string.slice(1).toLowerCase() : string.slice(1));
}

/**
 * 
 * @param {*} any
 * @returns query string
 */
export function generateQueryString(obj) {
    return obj ? Object.keys(obj).map(key => {
        const value = obj[key];
        if (Array.isArray(value)) {
            return value.map(item => `${encodeURIComponent(key)}[]=${encodeURIComponent(item)}`).join('&');
        }
        return `${encodeURIComponent(key)}=${encodeURIComponent(value)}`;
    }).join('&') : '';
}

/**
 * 
 * @param {*} document context
 * @param {*} file blob file
 * @param {*} fileName name of the file
 * @param {*} newTab if true, opens the file in a new tab
 */
export function downloadBlobFileButtonAction(document, file, fileName, newTab = false) {
    let link = document.createElement("a");
    link.href = URL.createObjectURL(file);
    link.style.display = "none";
    link.setAttribute("target", newTab ? "_blank" : "_self");
    link.setAttribute("download", fileName);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

export function isValidURL(url) {
    try {
        new URL(url);
        return true;
    } catch (e) {
        return false;
    }
}