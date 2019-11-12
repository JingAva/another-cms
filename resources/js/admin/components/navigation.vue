<template>
<div>
    <v-navigation-drawer v-model="drawer" app="app" width="220" class="navigation">
        <v-toolbar class="grey darken-4">
            <v-list>
                <v-list-item>
                    <v-list-item-content>
                      <v-list-item-title class="white--text">
                        <center>
                          <img src="/graphics/logo.png" width="150" />
                        </center>
                      </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-toolbar>
        <v-list
          dense
          nav
        >
          <v-list-item
            v-for="(item, icon) in mainMenu"
            :key="icon"
            link
            :to="item.link"
          >
            <v-list-item-icon>
              <v-icon>{{ icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title class="black--text">{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
    </v-navigation-drawer>
    <v-app-bar
      color="grey darken-4"
      app="app"
    >
      <v-app-bar-nav-icon  @click.stop="clickToggleDrawer">
        <v-icon class="white--text">menu</v-icon>
      </v-app-bar-nav-icon>

      <div class="flex-grow-1"></div>

      <v-btn icon>
        <v-icon class="white--text">search</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon class="white--text">notifications</v-icon>
      </v-btn>

      <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on }">
          <v-btn icon v-on="on">
            <v-icon class="white--text">more_vert</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item>
            <v-list-item-title>My Account</v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-title @click="logout">Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  </div>
</template>

<script>
  export default {
  data() {
    return {
      drawer: true,
      photo: '',
      mainMenu: {
        dashboard: {
          title: 'Dashboard',
          link: '/',
        },
        file_copy: {
          title: 'Pages',
          link: '/pages',
        },
        build: {
          title: 'General Settings',
          link: '/settings',
        },
        account_box: {
          title: 'Users',
          link: '/users',
        },
        receipt: {
          title: 'Reports',
          link: '/reports',
        },
      },
    }
  },
  methods: {
    clickToggleDrawer() {
      this.drawer = !this.drawer
    },
    logout() {
      axios.post('/logout').then(response => {
        location.reload();
      }).catch(error => {
         location.reload();
      });
    },
  },
}
</script>
