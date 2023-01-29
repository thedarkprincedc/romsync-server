### Docker steps

// build and tag image
docker build -t romsync-server-image .

// check image
docker image ls

// start image
docker run --name romsync-server-image -d -p 8070:3000 romsync-server-image