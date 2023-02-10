import { test, expect } from '@playwright/test';

let apiContext;

test.beforeAll(async ({ playwright, baseURL }) => {
    apiContext = await playwright.request.newContext({
        // All requests we send go to this API endpoint.
        baseURL: baseURL,
        extraHTTPHeaders: {
            // We set this header per GitHub guidelines.
            // 'Accept': 'application/vnd.github.v3+json',
            // Add authorization token to all requests.
            // Assuming personal access token available in the environment.
            //'Authorization': `token ${process.env.API_TOKEN}`,
        }
    });
})

test.afterAll(async ({ }) => {
    // Dispose all responses.
    await apiContext.dispose();
});

test('/api/login - should login (GET)', async({playwright}) => {
    const response = await apiContext.get(`/api/login/Ym1vc2xleTpEcmljYXNNNHg=`);
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})
test('/api/login - should login (POST) Bearer', async() => {
    const response = await apiContext.post(`/api/login`,
    {
        headers: {
            authorization: `Bearer Ym1vc2xleTpEcmljYXNNNHg=`
        }
    });
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})
test('/api/login - should login (POST) Basic', async() => {
    const response = await apiContext.post(`/api/login`, {
        headers: {
            authorization: `Basic Ym1vc2xleTpEcmljYXNNNHg=`
        }
    });
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

test('/api/logout - should login then logout', async() => {
    const response = await apiContext.get(`/api/logout`);
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

// test('/api/register - should register', async() => {

//     //const responses = await apiContext.get(`/api/login/Ym1vc2xleTpEcmljYXNNNHg=`);
//     const response = await apiContext.get(`/api/register`);
//     expect(response.ok()).toBeTruthy()
//     expect(response.status()).toBe(200)
// })

// test('/api/favorites - should get favorites', async() => {
//     const response = await apiContext.get(`/api/favorites`);
//     expect(response.ok()).toBeTruthy()
//     expect(response.status()).toBe(200)
// })