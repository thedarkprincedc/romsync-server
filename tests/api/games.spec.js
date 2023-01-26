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

test('should query a specific game', async() => {
    const response = await apiContext.get('/api/games', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
    //console.log(await response.json())
    //console.log(await response[0])
})

test('should query all games', async() => {
    const response = await apiContext.get('/api/games', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
    //console.log(await response.json())
})

test('should query all systems', async() => {
    const response = await apiContext.get('/api/years', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

test('should query all manufacturers', async() => {
    const response = await apiContext.get('/api/manufacturers', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})