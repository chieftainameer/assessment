<template>
<v-app>
    <v-main>
        <v-container>
            <v-app-bar app color="primary" dark>
                <v-app-bar-nav-icon></v-app-bar-nav-icon>
                <v-toolbar-title>Registration Form</v-toolbar-title>
            </v-app-bar>
            <v-snackbar
              v-model="snackbar"
            >
                {{ snackbarMsg }}

                <template v-slot:action="{ attrs }">
                    <v-btn
                    color="pink"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                    >
                    Close
                    </v-btn>
                </template>
            </v-snackbar>
            <v-row justify="center">
                <v-col
                    cols="12"
                    md="4"
                >
                    <form @submit="registration" enctype="multipart/form-data">
                        <v-text-field
                            clearable
                            v-model="name"
                            label="Name"
                            outlined
                            :rules="[rules.required]"
                        ></v-text-field>
                        <v-text-field
                            :value="email"
                            label="Email"
                            readonly
                            outlined
                            :rules="[rules.required,rules.email]"
                        ></v-text-field>
                        <v-text-field :rules="[rules.required,rules.counter]" clearable type="password" outlined v-model="password" label="Password"></v-text-field>
                        <v-text-field :rules="[rules.required]" clearable type="password" outlined v-model="cpassword" label="Confirm Password"></v-text-field>
                        <v-file-input
                                outlined
                                show-size
                                counter
                                label="Profile Photo"
                                v-model="file"
                                @change="onChange"
                            ></v-file-input>
                            <v-btn type="submit" color="primary">Sign up</v-btn>
                    </form>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</v-app>
</template>
<script>
export default{
    data:() => ({
        snackbar:false,
        snackbarMsg:'',
        email:'',
        name:'',
        password:'',
        cpassword:'',
        file:'',
        rules: {
          required: value => !!value || 'Required.',
          counter: value => value.length >= 8 || 'Min 8 characters',
          email: value => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            return pattern.test(value) || 'Invalid e-mail.'
          },
        },
    }),
    mounted(){
        this.email = this.$route.params.email;
    },
    methods:{
        onChange(e){
            this.file = e.target.files[0];
        },
        registration(e){
            e.preventDefault();
            if(this.password !== this.cpassword){
                this.snackbar = true;
                this.snackbarMsg = "Passwords Do not match";
            }
            else
            {
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                let data = new FormData();
                data.append('file', this.file);
                data.append('name', this.name);
                data.append('email', this.email);
                data.append('password', this.password);

                axios.post('http://localhost:8000/api/registration', data, config)
                    .then(function (res) {
                         console.log(res.data.message);
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
            }
        },
    }
}
</script>