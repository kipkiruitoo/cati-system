<template>
    <v-app>

                            <router-view></router-view>
                            <v-snackbar
                                    :timeout="6000"
                                    bottom
                                    right
                                    multi-line
                                    v-model="$root.snackbar"
                            >
                                {{ $root.snackbarMsg }}
                                <v-btn flat color="blue" @click.native="$root.snackbar = false">Close</v-btn>
                            </v-snackbar>
    </v-app>
</template>

<style>
    
</style>
