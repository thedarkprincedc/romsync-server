import { test, expect } from '@playwright/test';

let apiContext;

test.beforeAll(async ({ playwright, baseURL}) => {
    //testOptions.baseURL
    //console.log('effr')
    apiContext = await playwright.request.newContext({
        // All requests we send go to this API endpoint.
        baseURL: baseURL, 
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

test('/api/games - should query a specific game', async() => {
    const response = await apiContext.get('/api/games', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
   
    //console.log(await response.json())
    //console.log(await response[0])
})

test('/api/game - should query all games', async() => {
    const response = await apiContext.get('/api/games', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
    //console.log(await response.json())
})
test('/api/query - should query all games', async() => {
    const response = await apiContext.post('/api/query', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
    //console.log(await response.json())
})

test('/api/query - should query by id', async() => {
    const response = await apiContext.post('/api/query', {
        id: '63d3488f731cd637bdeaf3d1'
    })
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
    //console.log(await response.json())
})

test('/api/years - should query all years', async() => {
    const response = await apiContext.get('/api/years', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

test('/api/manufacturers - should query all manufacturers', async() => {
    const response = await apiContext.get('/api/manufacturers', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

test('/api/systems - should query all systems', async() => {
    const response = await apiContext.get('/api/systems', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})

test('/api/youtube - should query youtube', async() => {
    const response = await apiContext.get('/api/youtube/streetfighter 2', {})
    expect(response.ok()).toBeTruthy()
    expect(response.status()).toBe(200)
})