import axios from 'axios';
export default {
    data() {
        return {

        }
    },

    computed: {

    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (error) {
                return error.response;
            }
        },


        info(desc, title = 'Hey') {
            this.$Notice.info({
                title: title,
                desc: desc ? desc : 'Here is the info notification description.'
            });
        },
        success(desc, title = 'Great!') {
            this.$Notice.success({
                title: title,
                desc: desc ? desc : 'Here is the success notification description.'
            });
        },
        warning(desc, title = 'Opps!') {
            this.$Notice.warning({
                title: title,
                desc: desc ? desc : 'Here is the warning notification description.'
            });
        },
        error(desc, title = 'Opps!') {

            this.$Notice.error({
                title: title,
                // duration: 5000,
                desc: desc ? desc : 'Here is the error notification description.'
            });
        },
        swr(desc = 'Something Went Wrong! please try again.', title = 'Opps!') {
            this.$Notice.error({
                title: title,
                desc: desc ? desc : 'Here is the sometime wrong notification description.'
            });
        },

        resetForm(data) {
            data = {}
        },


        confirm(msg = 'Are you sure?') {
            return confirm(msg) ? true : false
        },

        isLoading(loading) {
            return loading ? 'loader' : ''
        },

        formatYmd(date) {
            return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD')
        },

        // dateFormat(date, from = 'YYYY-MM-DD', to = 'DD/MM/YYYY') {
        //     return moment(date, from).format(to)
        // },

        dateFormat(datetime) {
            return moment(datetime).format('DD-MM-YYYY');
        },


        statusName(status) {
            let data = {
                0: "Pending",
                1: "Published",
                2: "Draft",
            };
            return data[status];
        },

        statusColor(status) {
            let data = {
                'Paid': "badge badge-pill badge-success mr-1 mb-1",
                'Unpaid': "badge badge-pill badge-danger mr-1 mb-1",
            };
            return data[status];
        },



        // check has role
        hasRole(...role) {
            return window.App.user.role.split(':').some(userRole => role.indexOf(userRole) > -1)
        },

        // scroll to top
        scrollTop() {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },

        /* Decode Url Query String & convert into object */
        getUrlParams(search) {
            if (search == null || search == '' || search == undefined) {
                search = window.location.search
                if (search == '')
                    return {}
            }

            let hashes = search.slice(search.indexOf('?') + 1).split('&')
            return hashes.reduce((params, hash) => {
                let [key, val] = hash.split('=')
                return Object.assign(params, {
                    [key]: decodeURIComponent(val)
                })
            }, {})
        },

        /* Build Url Query String*/
        buildURLQuery(params = {}, searchQuery = null) {
            let qParams;
            if (searchQuery) {
                if (searchQuery === true) {
                    searchQuery = window.location.search
                }
                qParams = {...this.getUrlParams(searchQuery), ...params }
            } else {
                qParams = params
            }

            const esc = encodeURIComponent
            const query = Object.keys(qParams)
                .map(key => (qParams[key] === 'undefined' || qParams[key] == undefined || qParams[key] === null) ? esc(key) : `${esc(key)}=${esc(qParams[key])}`)
                .join('&')

            return query
        },

        /*Get plain text url search query string */
        getURLQueryString() {
            let queryParam = this.buildURLQuery(this.getUrlParams())
            return queryParam ? '?' + queryParam : ''
        },

        // common delete request
        async delete(url, params = {}) {
            return await axios.delete(url, params)
                .then(response => {
                    flash(response.data.message)
                    return true
                })
                .catch(error => {
                    flash(error.response.data.message, 'danger')
                    return false
                })
        },

        initFilters() {
            let queryParams = this.getUrlParams()
            for (let key in queryParams) {
                this[this.filterable][key] = queryParams[key]
                if (key == 'q') {
                    this.$store.dispatch('updateSearchStr', {
                        search_str: queryParams[key]
                    })
                }

            }
        },

        // UpperCase of 1st character in word
        firstCharUpperCase(sentiment) {
            const str = sentiment;
            const str2 = str.charAt(0).toUpperCase() + str.slice(1);
            return str2;
        },
    },

    computed: {
        subString() {
            return (content, length, suffix) => {
                return content.substring(0, length) + suffix;
            }
        },

        uppercase() {
            return (getString) => {
                return getString.toUpperCase()
            }
        },

        upperCaseFirst() {
            return (getString) => {
                return getString.charAt(0).toUpperCase() + getString.slice(1);
            }
        },

        capitalizeFirstLetterOfEachWord() {
            return (getString) => {
                //input: const getString = 'i have learned something new today';

                const arr = getString.split(" ");

                for (var i = 0; i < arr.length; i++) {
                    arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);

                }
                return arr.join(" ");
                ////Outptut: I Have Learned Something New Today
            }
        }



    },
}