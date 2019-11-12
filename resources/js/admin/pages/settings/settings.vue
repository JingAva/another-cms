<template>
  <v-app dark="dark">
      <Navigation />
      <v-content app="app">
          <v-container class="pa-4" fluid="fluid" grid-list-md="grid-list-md">
              <v-layout wrap="wrap">
                  <v-flex xs12="xs12">
                      <h1 class="display-1 mb-1">General Settings</h1>
                  </v-flex>
              </v-layout>
          </v-container>
          <v-data-table
            :headers="headers"
            :items="settings"
            sort-by="name"
            class="elevation-1"
            :loading="loading" 
            loading-text="Loading... Please wait"
            :search="search"
          >
            <template v-slot:top>
              <v-text-field v-model="search" label="Search" class="mx-4"></v-text-field>
              <v-toolbar flat color="white">
                <v-toolbar-title>Settings</v-toolbar-title>
                <v-divider
                  class="mx-4"
                  inset
                  vertical
                ></v-divider>
                <div class="flex-grow-1"></div>
                <v-dialog v-model="dialog" max-width="500px">
                  <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">New Setting</v-btn>
                  </template>
                  <v-card>
                    <v-card-title>
                      <span class="headline">{{ formTitle }}</span>
                    </v-card-title>
                    <v-card-text>
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="6" md="12">
                            <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-text-field v-model="editedItem.machinename" label="Machine Name"></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-textarea
                              solo
                              v-model="editedItem.value"
                              label="Value"
                            ></v-textarea>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card-text>

                    <v-card-actions>
                      <div class="flex-grow-1"></div>
                      <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                      <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
            <template v-slot:item.action="{ item }">
              <v-icon
                small
                class="mr-2"
                @click="editItem(item)"
              >
                edit
              </v-icon>
              <v-icon
                small
                @click="deleteItem(item)"
              >
                delete
              </v-icon>
            </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
          </v-data-table>
          <div class="text-center">
            <v-snackbar
              v-model="snackbar"
              :timeout="timeout"
            >
              {{ snackbarText }}
              <v-btn
                color="blue"
                text
                @click="snackbar = false"
              >
                Close
              </v-btn>
            </v-snackbar>
          </div>
    </v-content>
  </v-app>
</template>

<script>
import Navigation from '../../components/navigation'
import {isEmpty} from '../../utils/'

export default {
  components: {
    Navigation
  },
  data: () => ({
    dialog: false,
    snackbar: false,
    loading: true,
    snackbarText: '',
    search: '',
    timeout: 2000,
    headers: [
      {
        text: 'Name',
        align: 'left',
        sortable: false,
        value: 'name',
      },
      { text: 'Value', value: 'value' },
      { text: 'Actions', value: 'action', sortable: false },
    ],
    settings: [],
    editedIndex: -1,
    editedItem: {
      name: '',
      machinename: '',
      value: '',
    },
    defaultItem: {
      name: '',
      machinename: '',
      value: '',
    },
    show1: false,
    show2: false,
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Setting' : 'Edit Setting'
    },
  },

  watch: {
    dialog (val) {
      val || this.close()
    },
  },

  created () {
    this.initialize()
  },

  methods: {
    initialize () {

      axios.get('/api/settings')
            .then(response => {
          
          if (response.data) {
            let settings = Object.keys(response.data).map((k) => response.data[k])
            this.settings = settings[0];
            this.loading = false;
          }

      })
      .catch(response => {
          console.log(response);
      });

    },

    editItem (item) {
      this.editedIndex = this.settings.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      const index = this.settings.indexOf(item)

      if (confirm('Are you sure you want to delete this setting?')) {
        axios.delete(`/api/settings/${item.id}`)
        .then(res => this.settings.splice(index, 1));
      }

    },

    close () {
      this.dialog = false
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      }, 300)
    },

    save () {

      let valid = true;
      if (isEmpty(this.editedItem.name)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a name.';
      }

      if (isEmpty(this.editedItem.machinename)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a name.';
      }

      if (isEmpty(this.editedItem.value)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a value.';
      }

      if (valid == true) {

        if (this.editedIndex > -1) {

          axios.patch(`/api/settings/${this.editedItem.id}`, this.editedItem)
          .then(response => {
            let settings = Object.keys(response.data).map((k) => response.data[k])
            Object.assign(this.settings[this.editedIndex], settings[0])
          });

        } else {

          axios.post(`/api/settings`, this.editedItem)
          .then(response => {

            let settings = Object.keys(response.data).map((k) => response.data[k])
            this.settings.push(settings[0])
          });

        }

        this.close()
      } 
      
    },
  },
}
</script>