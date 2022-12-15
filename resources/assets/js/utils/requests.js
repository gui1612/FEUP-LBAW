const endpoints = {
    'rating.get': (postId) => ['GET', `/api/posts/${postId}/rating`],
    'rating.set': (postId) => ['POST', `/api/posts/${postId}/rating`],
    'rating.remove': (postId) => ['DELETE', `/api/posts/${postId}/rating`],
    'user.follow': (userId) => ['POST', `/users/${userId}/follow`],
    'user.unfollow': (userId) => ['DELETE', `/users/${userId}/unfollow`]
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
