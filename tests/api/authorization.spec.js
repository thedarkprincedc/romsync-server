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
    const login = await apiContext.get(`/api/login`);
    expect(login.ok()).toBeTruthy();
    // const newIssue = await apiContext.post(`/repos/${USER}/${REPO}/issues`, {
    //     data: {
    //       title: '[Feature] request 1',
    //     }
    //   });
    //   expect(newIssue.ok()).toBeTruthy();
})

test('should login then logout', async() => {
    const login = await apiContext.get(`/api/logout`);
    expect(login.ok()).toBeTruthy();
})

test('should register', async() => {
    const login = await apiContext.get(`/api/register`);
    expect(login.ok()).toBeTruthy();
})

test('should get favorites', async() => {
    const login = await apiContext.get(`/api/favorites`);
    expect(login.ok()).toBeTruthy();
})