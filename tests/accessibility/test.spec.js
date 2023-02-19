// import { chromium, Browser, Page } from 'playwright'
// import { injectAxe, checkA11y, getViolations, reportViolations } from 'axe-playwright'
// import { test, expect } from '@playwright/test';
// let browser;
// let page;

// //describe('Playwright web page accessibility test', () => {
//   test.beforeAll(async () => {
//     browser = await chromium.launch()
//     page = await browser.newPage()
//     await page.goto(`file://${process.cwd()}/test/site.html`)
//     await injectAxe(page)
//   })

//   it('simple accessibility run', async () => {
//     await checkA11y(page)
//   })

//   it('check a11y for the whole page and axe run options', async () => {
//     await checkA11y(page, null, {
//       axeOptions: {
//         runOnly: {
//           type: 'tag',
//           values: ['wcag2a'],
//         },
//       },
//     })
//   })

//   it('check a11y for the specific element', async () => {
//     await checkA11y(page, 'input[name="password"]', {
//       axeOptions: {
//         runOnly: {
//           type: 'tag',
//           values: ['wcag2a'],
//         },
//       },
//     })
//   })

//   it('gets and reports a11y for the specific element', async () => {
//     const violations = await getViolations(page, 'input[name="password"]', {
//       runOnly: {
//         type: 'tag',
//         values: ['wcag2a'],
//       },
//     })

//     reportViolations(violations, new YourAwesomeCsvReporter('accessibility-report.csv'))

//     expect(violations.length).toBe(0)
//   })

//   afterAll(async () => {
//     await browser.close()
//   })
// //})