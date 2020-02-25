export default {
    methods: {
        sendResponseTime(startTime) {
            let timeDiff = moment().diff(startTime)

            if (this.shouldSendResponseTime(timeDiff)) {
                let data = {
                    'time': timeDiff
                }
    
                if (navigator != undefined) {
                    let userAgent = {
                        'user_agent' : {
                            'platform': navigator.platform,
                            'user_agent': navigator.userAgent,
                            'browser_version': navigator.appVersion,
                            'language': navigator.language,
                            'resolution': `${window.outerWidth}x${window.outerHeight}`
                        }
                    }
    
                    data = _.merge(data, userAgent)
                }
    
                axios.post('/api/users/response-time', data)
                    .then((response)=> {
                        //
                    })
                    .catch((error) => {
                        console.log(error.response)
                    })
            }
        },

        shouldSendResponseTime(timeDiff) {
            let randomNumber = _.random(1, 100)

            if (timeDiff > 1000 || !_.inRange(randomNumber, 6, 94)) {
                return true;
            }

            return false;
        }
    }
}