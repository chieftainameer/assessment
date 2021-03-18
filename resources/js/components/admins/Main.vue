<template>
<v-app>
    <v-app-bar app color="green accent-4" dark>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <v-toolbar-title>Laravel assessment Admin</v-toolbar-title>
        <v-spacer></v-spacer>
        
    </v-app-bar>
    <v-main>
        <v-container>

            <v-dialog
                v-model="modal"
                width="500"
                >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                    color="green lighten-2"
                    dark
                    v-bind="attrs"
                    v-on="on"
                    >
                    Invite User
                    </v-btn>
                </template>

            <v-card>
                <v-card-title class="headline green">
                User Invitation
                </v-card-title>

                <v-card-text>
                    <v-text-field v-model="email" placeholder="Enter users email" label="User Email" ></v-text-field>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="red lighten-2"
                    text
                    @click="modal = false"
                >
                     Cancel
                </v-btn>
                <v-btn
                    color="green lighten-2"
                    text
                    @click="sendEmail"
                >
                    Send Invite
                </v-btn>
                </v-card-actions>
            </v-card>
           </v-dialog>
            
         <v-row>
                    <v-col cols="12" >
                    <v-simple-table
                        fixed-header
                        height="300px"
                    >
                <template v-slot:default>
                    <thead>
                        <tr>
                        <th class="text-left">
                            Email
                        </th>
                        <th class="text-left">
                            Status
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in userData" :key="user.id">
                            <td>{{  user.email }}</td>
                            <td>{{  user.invite_status }}</td>
                        </tr>
                    </tbody>
                 </template>
                </v-simple-table>
            </v-col>
         </v-row>


         <v-row>
             <v-col cols="12" >
                <v-simple-table
                    fixed-header
                    height="500px"
                >
                <template v-slot:default>
                    <thead>
                        <tr>
                        <th class="text-left">
                            Name
                        </th>
                        <th class="text-left">
                            Email
                        </th>
                        <th class="text-left">
                            Status
                        </th>
                        <th class="text-left">
                            Actions
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in registeredUsers" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.status }}</td>
                            <td>
                                <v-dialog v-model="dialog" width="700" transition="dialog-bottom-transition">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                        color="primary lighten-2"
                                        dark
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="openDialog(user)"
                                        >
                                        View
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-card-title class="headline green">User Details</v-card-title>
                                        <v-row justify="center" class="mt-5">
                                            <v-col cols="6">
                                                <v-img class="avatar" :src="user.avatar"></v-img>
                                            </v-col>
                                        </v-row>
                                        <v-divider class="mt-5"></v-divider>
                                        <v-row justify="center">
                                            <v-col cols="6">
                                                <v-divider></v-divider>
                                                <v-card-title>
                                                    {{ user.name }}
                                                </v-card-title>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-divider></v-divider>
                                                <v-card-title>
                                                    {{ user.email }}
                                                </v-card-title>
                                            </v-col>
                                        </v-row>
                                        <v-card-actions>
                                            <v-btn @click="blockUser(user.email)" right color="red lighten-2">Block User</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </td>
                        </tr>
                    </tbody>
                </template>
              </v-simple-table>
            </v-col>
         </v-row>



    <v-snackbar
              v-model="snackbar"
            >
      {{ snackbarMessage }}

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
    </v-container>
    </v-main>
    </v-app>
</template>
<script>
export default{
    data: () => ({
        modal:false,
        email:'',
        snackbar:false,
        snackbarMessage:'',
        userData:[],
        registeredUsers:[],
        dialogUser:'',
        dialog:false,
    }),
    methods:{
        sendEmail(){
            axios.post('http://localhost:8000/api/send-mail',{'email':this.email})
            .then(res => {
                this.modal = false;
                this.snackbar = true;
                this.snackbarMessage = res.data.message;
                t
            })
            .catch(err => {
                this.modal = false;
                this.snackbar = true;
                this.snackbarMessage = res.data.message;
            })
        },
        openDialog(user){
            this.dialogUser = user;
            console.log(user);
        },
        blockUser(email){
            axios.post('http://localhost:8000/api/block',{'email':email})
            .then(res => {
                this.dialog = false;
                this.snackbar = true;
                this.snackbarMessage = res.data.message;
            })
            .catch(err => {
                this.dialog = false;
                this.snackbar = true;
                this.snackbarMessage = res.data.message;
            })
        }
    },
    computed:{
        UserData(){  
            return this.dialogUser;
         }
    },
    mounted(){
        axios.get('http://localhost:8000/api/invitations')
        .then(res => {
            this.userData = res.data.users;
        })
        .catch(err => {
            this.snackbar = true;
            this.snackbarMessage = err;
        });

        axios.get('http://localhost:8000/api/all_users')
        .then(res => {
            this.registeredUsers = res.data.users;
        })
        .catch(err => {
            this.snackbar = true;
            this.snackbarMessage = err;
        });

    }
}
</script>
<style>
.modal-btn{
    position:absolute;
    top:4;
    right:0;
}
.avatar{
    border-radius: 50%;
}
</style>