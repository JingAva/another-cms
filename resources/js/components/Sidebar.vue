<template>
<v-card
    height="400"
    width="256"
    class="mx-auto admin-sidebar"
  >
    <v-navigation-drawer permanent fixed>
      <v-list
        dense
        nav
      >
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
        >
          <a :href="item.link" class="admin-sidebar__item-link">
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </a>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        items: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard', link: '#dashboard' },
          { title: 'Photos', icon: 'mdi-image', link: '#photos' },
          { title: 'About', icon: 'mdi-help-box', link: '#about' },
        ],
        right: null,
      }
    },
  }
</script>
