<template>
<v-app>
    <v-app-bar app color="deep-purple accent-4" dark>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <v-toolbar-title>Laravel assessment</v-toolbar-title>
        <v-spacer></v-spacer>
        <router-link to="/admin">
        <v-btn color="deep-purple accent-3">
            <v-icon left>mdi-heart</v-icon>
            Admin
        </v-btn>
        </router-link>
    </v-app-bar>
    <v-main>
        <v-container>
          <v-alert color="green">Users Component here</v-alert>
        </v-container>
    </v-main>
    <router-view />
    </v-app>
</template>
<script>
export default{
    mounted(){
        console.log('home mounted');
    }
}
</script>