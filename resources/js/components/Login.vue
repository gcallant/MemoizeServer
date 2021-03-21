<template>
    <div>
        <h1 class="font-normal text-black-100 text-3xl leading-none mb-8"
        >Login</h1>

        <div id="hidden" :class="hidden">

            <div class="my-5 mx-auto flex">
                <div class="card">
                    <qrcode :value="this.qrcodeValue" :options="{width: 300}"></qrcode>
                </div>
                <div class="card justify-between">
                    <picture>
                        <img src="images/approval-mobile.svg" class="w-40" alt="mobile">
                    </picture>
                    <h5>Scan QRcode with your phone to login</h5>
                    <img src="/images/spinner.svg" alt="">
                </div>
            </div>

        </div>

        <button type="submit" v-on:click="submit" :class="buttonClass">
            Login
        </button>

    </div>
</template>

<script>
export default {
    created() {
        axios.get('/api/randomBytes').then(response => {
            this.qrcodeValue = response.data;
        });
    },

    data() {
        return {
            qrcodeValue: 'Error: No Random Data Available',
            hidden: 'd-none',
            buttonClass: 'btn btn-primary btn-user btn-block',
        };
    },

    methods: {
        async submit() {
            this.hidden = "";
            this.buttonClass = "d-none";
            Echo.channel(this.qrcodeValue)
                .listen('.approval-granted', await this.getTokenAndRedirectToHome);
        },
        async getTokenAndRedirectToHome() {
            try {
                let response = await axios.post('/api/login/confirm', {
                        'code': this.qrcodeValue
                    }
                );


                if (response.status === 200 && response.data.access_token) {
                    localStorage.setItem('memoizeToken', response.data.access_token);
                    window.location = '/home';
                } else {
                    alert("Error: Unauthorized, please try again")
                }
            } catch (e) {
                alert("Error: Unauthorized, please try again")
            }
        }
    },
};
</script>

<style scoped>

</style>
