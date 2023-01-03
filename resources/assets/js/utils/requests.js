const endpoints = {
    'rating.get': (postId) => ['GET', `/api/posts/${postId}/rating`],
    'rating.set': (postId) => ['POST', `/api/posts/${postId}/rating`],
    'rating.remove': (postId) => ['DELETE', `/api/posts/${postId}/rating`],
    'comment.rating.get': (commentId) => ['GET', `/api/comments/${commentId}/rating`],
    'comment.rating.set': (commentId) => ['POST', `/api/comments/${commentId}/rating`],
    'comment.rating.remove': (commentId) => ['DELETE', `/api/comments/${commentId}/rating`],
    'user.follow': (userId) => ['POST', `/users/${userId}/follow`],
    'user.unfollow': (userId) => ['DELETE', `/users/${userId}/unfollow`],
    'forum.follow': (forumId) => ['POST', `/forums/${forumId}/follow`],
    'forum.unfollow': (forumId) => ['DELETE', `/forums/${forumId}/unfollow`],
    'notifications.navbar': () => ['GET', '/api/notifications/navbar'],
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
