const endpoints = {
    'rating.get': (postId) => ['GET', `/api/post/${postId}/rating`],
    'rating.set': (postId) => ['POST', `/api/post/${postId}/rating`],
    'rating.remove': (postId) => ['DELETE', `/api/post/${postId}/rating`]
}

export function makeRequest([key, ...params], { data, ...rest }) {
    if (!endpoints[key]) {
        console.error(`No endpoint found with key ${key}, aborting...`);
        return;
    }

    const [method, location] = endpoints[key](...params);
    return fetch(location, {
        ...rest,
        method: method,
        body: data,
    });
}
