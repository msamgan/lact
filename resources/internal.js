export const throwException = (r) => {
    if (!r.ok || !String(r.status).startsWith('20')) {
        throw new Error(`HTTP error! status: ${r.status} ${r.statusText}`);
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
