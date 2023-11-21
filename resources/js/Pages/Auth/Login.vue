<template>

    <div class="flex min-h-full">
        <div
            class="relative z-10 flex flex-1 flex-col bg-white py-10 px-4 shadow-2xl sm:justify-center md:flex-none md:px-28">
            <div class="mx-auto w-full max-w-md sm:px-4 md:w-96 md:max-w-sm md:px-0">
                <div class="flex flex-col">
                    <a aria-label="Home" href="/">
                        <img src="/images/full_logo.png" alt="" class="h-16 w-auto">
                    </a>
                    <div class="mt-20">
                        <h2 class="text-lg font-semibold text-gray-900">Sign in to your account</h2>
                        <p class="mt-1 text-sm text-gray-700">This panel is only for Sangaath Internal Team</p>
                    </div>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-y-8">
                    <div v-if="login_form.login_error_msg" class="border-l-4 border-red-400 bg-red-50 p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true"/>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    {{ login_form.login_error_msg }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <InputLabel for="email" value="Email"/>

                        <div class="relative rounded-md shadow-sm">
                            <TextInput v-model="login_form.email.value"
                                       id="email" type="email" class="block w-full font-medium" required/>
                        </div>
                        <p v-if="login_form.email.error" class="mt-1 text-red-600 text-sm">Please enter valid email</p>
                    </div>
                    <div class="">
                        <InputLabel for="password" value="Password"/>

                        <div class="relative rounded-md shadow-sm">
                            <TextInput v-model="login_form.password.value"
                                       id="password" type="password" class="block w-full font-medium" required/>
                        </div>
                        <p v-if="login_form.password.error" class="mt-1 text-red-600 text-sm">Please enter valid
                            password</p>
                    </div>
                    <div>
                        <button v-if="!login_form.processing" @click="validateForm()"
                                class="group inline-flex items-center justify-center rounded-full py-2 px-4 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600 w-full"
                                type="submit">
                            <span>Sign In <span aria-hidden="true">→</span></span>
                        </button>
                        <button v-else-if="login_form.processing"
                                class="group inline-flex items-center justify-center rounded-full py-2 px-4 text-sm font-semibold bg-blue-600 opacity-60 text-white w-full"
                                type="submit">
                            <span>Verifying</span>
                            <svg class="animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" src="/images/background-auth.jpg" alt=""/>
        </div>
    </div>
</template>

<script>
    import TextInput from '@/Components/TextInput.vue';
    import InputLabel from '@/Components/InputLabel.vue';

    import {XCircleIcon} from '@heroicons/vue/20/solid'

    export default {
        components: {
            TextInput,
            InputLabel,
            XCircleIcon
        },

        data() {
            return {
                login_form: {
                    email: {
                        value: "",
                        error: false
                    },
                    password: {
                        value: "",
                        error: false
                    },
                    processing: false,
                    login_error_msg: null
                }
            }
        },

        methods: {
            validateForm() {
                this.login_form.email.error = false;
                this.login_form.password.error = false;
                this.login_form.login_error_msg = null;

                let email = this.login_form.email.value.toString();
                if (!this.isEmailValid(email)) {
                    this.login_form.email.error = true;
                    return;
                }

                let password = this.login_form.password.value.toString();
                if (password.length < 8) {
                    this.login_form.password.error = true;
                    return;
                }

                this.login_form.processing = true;

                this.verifyLoginDetails();
            },

            verifyLoginDetails() {
                let emailString = this.login_form.email.value.toString();
                let passwordString = this.login_form.password.value.toString();

                let formData = new FormData();
                formData.append("email", emailString);
                formData.append("password", passwordString);

                let vue = this;
                axios.post("/login", formData).then(function (response) {
                    // alert('hoi');
                    let data = response.data;
                    let status = response.data.status;
                    console.log(status);
                    if (status == 1) {
                        vue.$inertia.visit('/dashboard', {replace: true});
                    } else {
                        vue.login_form.processing = false;
                        vue.login_form.login_error_msg = data.error_msg;
                    }
                });
            },

            isEmailValid(email) {
                return /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+([^<>()\.,;:\s@\"]{2,}|[\d\.]+))$/.test(email);
            }
        },
    }

</script>
