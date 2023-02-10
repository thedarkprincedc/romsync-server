import { defineConfig } from '@playwright/test';

process.env.API_TOKEN = "Ym1vc2xleTpEcmljYXNNNHg="
export default defineConfig({
    webServer: [
    {
        command: 'npm run start',
        port: 3000,
        timeout: 120 * 1000,
        reuseExistingServer: !process.env.CI,
    },
    // {
    //   command: 'npm run backend',
    //   port: 3333,
    //   timeout: 120 * 1000,
    //   reuseExistingServer: !process.env.CI,
    // }
    ],

    /* Reporter to use. See https://playwright.dev/docs/test-reporters */
    reporter: [
        //['dot'],
        ['list'],
       // ['html']
    ],
    use: {
        baseURL: 'http://localhost:3000/',
        //apiToken: process.env.API_TOKEN || 'Ym1vc2xleTpEcmljYXNNNHg='
    },
});