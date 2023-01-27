const Sentry = require("@sentry/node");
const Tracing = require("@sentry/tracing");
const config = require('config')

Sentry.init(config.sentry);

const SentryRequestHandler = Sentry.Handlers.requestHandler
const SentryErrorHandler = Sentry.Handlers.errorHandler

module.exports = {
  SentryRequestHandler,
  SentryErrorHandler
};