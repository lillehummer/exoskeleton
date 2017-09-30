const Nightmare = require('nightmare')
const testingUrl = 'https://news.ycombinator.com/'

Nightmare({
    show: false,
    openDevTools: false,
    waitTimeout: 5000
})
    .goto(testingUrl)
    .evaluate( () => {
        debugger
        return document.querySelector('.selector').href
    })
    .end()
    .then(result => console.log(result))
    .catch(error => console.error(error))
