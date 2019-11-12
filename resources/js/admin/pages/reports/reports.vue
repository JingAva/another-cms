<template>
  <v-app dark="dark">
      <Navigation />
      <v-content app="app">
          <v-container class="pa-4" fluid="fluid" grid-list-md="grid-list-md">
              <v-layout wrap="wrap">
                  <v-flex xs12="xs12">
                      <h1 class="display-1 mb-1">Reports</h1>
                  </v-flex>
              </v-layout>
          </v-container>
      </v-content>
  </v-app>
</template>
<script>
import Navigation from '../../components/navigation'

export default {
  components: {
    Navigation
  },
}
</script>