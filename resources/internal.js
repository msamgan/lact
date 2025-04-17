export const throwException = (response) => {
    if (!response.ok || !String(response.status).startsWith('20')) {
        throw new Error(`HTTP error from Lact! status: ${response.status} ${response.statusText}`);
    }
};

export const baseHeaders = (headers) => {
    return {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf"]').content,
        'Content-Type': 'application/json',
        accept: 'application/json',
        ...headers
    };
};

export const makeErorObject = (response) => {
    if (!response.ok || !String(response.status).startsWith('20')) {
        return {
            ok: response.ok,
            status: response.status,
            message: response.statusText
        };
    }

    return {};
};

export const loadValidationErrors = (responseJson) => {
    return getFirstValues(responseJson.errors)
}

export const validationStatusErrorCode = 422

function getFirstValues(obj) {
    return Object.keys(obj).reduce((result, key) => {
        result[key] = obj[key][0];
        return result;
    }, {});
}
