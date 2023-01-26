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
    const games = await apiContext.get('/api/games/sfiii', {})
    expect(games.ok()).toBeTruthy()
})

test('should query all games', async() => {
    const games = await apiContext.get('/api/games', {})
    expect(games.ok()).toBeTruthy()
})

test('should query all systems', async() => {
    const games = await apiContext.get('/api/years', {})
    expect(games.ok()).toBeTruthy()
})

test('should query all manufacturers', async() => {
    const games = await apiContext.get('/api/manufacturers', {})
    expect(games.ok()).toBeTruthy()
})