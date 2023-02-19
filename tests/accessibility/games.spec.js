// import { test, expect } from '@playwright/test';
// const AxeBuilder = require('@axe-core/playwright').default;
// const playwright = require('playwright');

// let apiContext;
// test.beforeAll(async ({ playwright, baseURL}) => {
//   apiContext = await playwright.request.newContext({
//       // All requests we send go to this API endpoint.
//       baseURL: baseURL, 
//       extraHTTPHeaders: {
//           // We set this header per GitHub guidelines.
//           // 'Accept': 'application/vnd.github.v3+json',
//           // Add authorization token to all requests.
//           // Assuming personal access token available in the environment.
//           //'Authorization': `token ${process.env.API_TOKEN}`,
//       }
//   });
//   //await apiContext.get(`/api/login/${process.env.API_TOKEN}`);
// })

// test.afterAll(async ({ }) => {
//   // Dispose all responses.
//   //await apiContext.get(`/api/logout`)
//   await apiContext.dispose();
// });

// test("Visit home page and run an axe test @axe", async ({ page }, testInfo) => {
//   await page.goto("https://localhost:4200");

//   //Analyze the page with axe
//   const accessibilityScanResults = await new AxeBuilder({ page }).analyze();

//   //Attached the violations to the test report
//   await testInfo.attach("accessibility-scan-results", {
//     body: JSON.stringify(accessibilityScanResults.violations, null, 2),
//     contentType: "application/json",
//   });

//   //Console log the violations
//   let violation = accessibilityScanResults.violations;
//   violation.forEach(function (entry) {
//     console.log(entry.impact + " " + entry.description);
//   });

//   //Expect violations to be empty
//   expect(accessibilityScanResults.violations).toEqual([]);
// });