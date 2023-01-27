const forge = require('node-forge');
const crypto = require('crypto');
const fs = require('fs');
const path = require('path');
const pki = forge.pki;

const certificateDir = path.join(__dirname, '/../certs')

const certificatePath = `${certificateDir}/certificate.pem`;
const privateKeyPath = `${certificateDir}/privateKey.pem`;
const publicKeyPath = `${certificateDir}/publicKey.pem`;

const attrs = [{
    name: 'commonName',
    value: 'localhost'
}, {
    name: 'countryName',
    value: 'US'
}, {
    shortName: 'ST',
    value: 'Virginia'
}, {
    name: 'localityName',
    value: 'Alexandria'
}, {
    name: 'organizationName',
    value: 'EDW Dashboard Team'
}, {
    shortName: 'OU',
    value: 'Test'
}];

// generate a keypair and create an X.509v3 certificate
var keys = pki.rsa.generateKeyPair(2048);
var cert = pki.createCertificate();
cert.publicKey = keys.publicKey;

cert.serialNumber = '01' + crypto.randomBytes(19).toString("hex");
cert.validity.notBefore = new Date();
cert.validity.notAfter = new Date();
cert.validity.notAfter.setFullYear(cert.validity.notBefore.getFullYear() + 1); // adding 1 year of validity from now
cert.setSubject(attrs);
cert.setIssuer(attrs);

// self-sign certificate
cert.sign(keys.privateKey);

const result = {
    // convert a Forge certificate to PEM
    cert: pki.certificateToPem(cert),
    privateKey: pki.privateKeyToPem(keys.privateKey),
    publicKey: pki.publicKeyToPem(keys.publicKey)
};

console.log('%s\n%s\n%s', result.cert, result.privateKey, result.publicKey);

if(!fs.existsSync(certificateDir)){
    fs.mkdirSync(certificateDir);
    console.log('Created directory: $s', certificateDir)
}

fs.writeFileSync(certificatePath, result.cert)
fs.writeFileSync(privateKeyPath, result.privateKey)
fs.writeFileSync(publicKeyPath, result.publicKey)

console.log("\nWritten files Successfully\n%s\n%s\n%s\n", 
    certificatePath, privateKeyPath, publicKeyPath
);
