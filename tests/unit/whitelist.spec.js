import { test, expect } from '@playwright/test';
const whitelist  = require('../../libs/whitelist.js')

test('whitelist should be true', ({}) => {
    const result = whitelist.isUrlWhitelisted('/api/login', 'GET')
    expect(result).toBe(true)
    const result2 = whitelist.isUrlWhitelisted('/api/register', 'GET')
    expect(result).toBe(true)
    const result6 = whitelist.isUrlWhitelisted('/api/hregister', 'GET')
    expect(result).toBe(true)
})
