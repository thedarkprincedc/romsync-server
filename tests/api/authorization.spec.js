import { test, expect } from '@playwright/test';

let apiContext;

test.beforeAll(async ({ playwright }) => {
    apiContext = await playwright.request.newContext({
        // All requests we send go to this API endpoint.
        baseURL: process.env.ROMSYNC_URL || 'http://localhost:3000',
        extraHTTPHeaders: {
            // We set this header per GitHub guidelines.
           // 'Accept': 'application/vnd.github.v3+json',
            // Add authorization token to all requests.
            // Assuming personal access token available in the environment.
            //'Authorization': `token ${process.env.API_TOKEN}`,
        },
    });
})

test.afterAll(async ({ }) => {
    // Dispose all responses.
    await apiContext.dispose();
});

test('should login', async() => {
    const response = await apiContext.get(`/api/login`);
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

test('should login then logout', async() => {
    const response = await apiContext.get(`/api/logout`);
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

test('should register', async() => {
    const response = await apiContext.get(`/api/register`);
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

test('should get favorites', async() => {
    const response = await apiContext.get(`/api/favorites`);
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})