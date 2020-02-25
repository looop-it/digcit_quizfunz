export default {
    methods: {
        sendStats() {
            if (navigator != undefined) {
                let data = {
                    'page': this.page ? this.page : 'unknown',
                    'platform': navigator.platform,
                    'user_agent': navigator.userAgent,
                    'browser_version': navigator.appVersion,
                    'language': navigator.language,
                    'resolution': `${window.outerWidth}x${window.outerHeight}`,
                    'date': moment().format('YYYY-MM-DD HH:mm:ss')
                }

                axios.post('/api/users/stats', data)
                    .then((response)=> {
                        //
                    })
                    .catch((error) => {
                        console.log(error.response)
                    })
            }
        }
    }
}