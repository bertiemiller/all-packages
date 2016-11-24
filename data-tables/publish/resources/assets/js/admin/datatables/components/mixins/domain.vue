<script>
    export default{
        computed: {
            apiDomain () {
//                return 'http://' + document.querySelector('meta[name="_domain"]')['content'].replace("http://", "");
                return 'http://' + document.querySelector('meta[name="_core_api_domain"]')['content'].replace("http://", "");
//                console.log('Domain: ' + domain);
//                var res = str.replace("Microsoft", "W3Schools");
            },
            siteDomain () {
                return 'http://' + document.querySelector('meta[name="_domain"]')['content'].replace("http://", "");
//                console.log('Domain: ' + domain);
            },
            sourcesDomain () {
                return 'http://' + document.querySelector('meta[name="_sources_domain"]')['content'].replace("http://", "");
//                console.log('Domain: ' + domain);
            },
            modelsDomain () {
                return 'http://' + document.querySelector('meta[name="_models_domain"]')['content'].replace("http://", "");
//                console.log('Domain: ' + domain);
            }
        }
    }
</script>
