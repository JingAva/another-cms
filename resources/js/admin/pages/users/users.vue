<template>
  <v-app dark="dark">
      <Navigation />
      <v-content app="app">
          <v-container class="pa-4" fluid="fluid" grid-list-md="grid-list-md">
              <v-layout wrap="wrap">
                  <v-flex xs12="xs12">
                      <h1 class="display-1 mb-1">User Management</h1>
                  </v-flex>
              </v-layout>
          </v-container>
          <v-data-table
            :headers="headers"
            :items="users"
            sort-by="email"
            class="elevation-1"
            :loading="loading" 
            loading-text="Loading... Please wait"
            :search="search"
          >
            <template v-slot:top>
              <v-text-field v-model="search" label="Search" class="mx-4"></v-text-field>
              <v-toolbar flat color="white">
                <v-toolbar-title>Users</v-toolbar-title>
                <v-divider
                  class="mx-4"
                  inset
                  vertical
                ></v-divider>
                <div class="flex-grow-1"></div>
                <v-dialog v-model="dialog" max-width="700px">
                  <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">New User</v-btn>
                  </template>
                  <v-card>
                    <v-card-title>
                      <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="6" md="12" v-if="editedItem.photo">
                            <img :src="`/images/${editedItem.photo}`" width="150" />
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <input 
                              type="file" 
                              class="form-control" 
                              @change="onImageChange"
                            />
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-text-field
                              v-model="editedItem.password"
                              :append-icon="show1 ? 'visibility' : 'visibility_off'"
                              :type="show1 ? 'text' : 'password'"
                              name="input-10-2"
                              label="Password"
                              hint="At least 8 characters"
                              value=""
                              class="input-group--focused"
                              @click:append="show1 = !show1"
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-text-field
                              v-model="editedItem.confirmpassword"
                              :append-icon="show2 ? 'visibility' : 'visibility_off'"
                              :type="show2 ? 'text' : 'password'"
                              name="input-10-2"
                              label="Confirm password"
                              hint="At least 8 characters"
                              value=""
                              class="input-group--focused"
                              @click:append="show2 = !show2"
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="6">
                            <v-select
                              :items="roles"
                              label="Access Group"
                              outlined
                              v-model="editedItem.role"
                            ></v-select>
                          </v-col>
                          <v-col cols="12" sm="6" md="6">
                            <v-radio-group v-model="editedItem.status">
                              <v-radio
                                :label="`Active`"
                                :value="1"
                              ></v-radio>
                              <v-radio
                                :label="`Blocked`"
                                :value="0"
                              ></v-radio>
                            </v-radio-group>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-textarea
                              solo
                              v-model="editedItem.about"
                              label="About"
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
    roles: ['client', 'administrator'],
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
      { text: 'Email', value: 'email' },
      { text: 'Access Group', value: 'role' },
      { text: 'Status', value: 'status_display' },
      { text: 'Actions', value: 'action', sortable: false },
    ],
    users: [],
    editedIndex: -1,
    editedItem: {
      name: '',
      email: '',
      role: '',
      status: '',
      about: '',
      password: '',
      photo: '',
      confirmpassword: '',
    },
    defaultItem: {
      name: '',
      email: '',
      role: '',
      status: '',
      about: '',
      password: '',
      photo: '',
      confirmpassword: '',
    },
    show1: false,
    show2: false,
    password: 'Password',
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New User' : 'Edit User'
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

      axios.get('/api/users')
            .then(response => {
          
          if (response.data) {
            let users = Object.keys(response.data).map((k) => response.data[k])
            this.users = users[0];
            this.loading = false;
          }

      })
      .catch(response => {
          console.log(response);
      });

    },
    onImageChange(e) {

      var files = e.target.files || e.dataTransfer.files;
      if (!files.length)
      return;  

      let image = e.target.files[0];

      let currentObj = this;
      const config = {
        headers: { 'content-type': 'multipart/form-data' }
      }

      let formData = new FormData();
      formData.append('image', image);

      axios.post('/api/formSubmit', formData, config)
      .then(res => {
        this.editedItem.photo = res.data.data
      });

    },

    editItem (item) {
      this.editedIndex = this.users.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      const index = this.users.indexOf(item)

      if (confirm('Are you sure you want to delete this user?')) {
        axios.delete(`/api/users/${item.id}`)
        .then(res => this.users.splice(index, 1));
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

      if (this.editedItem.status) {
        this.editedItem.status_display = 'Active';
      } else {
        this.editedItem.status_display = 'Blocked';
      }

      let valid = true;
      if (isEmpty(this.editedItem.id) && isEmpty(this.editedItem.password)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a password.';
      }

      if (!isEmpty(this.editedItem.password)) {

        if (this.editedItem.password !== this.editedItem.confirmpassword) {
          valid = false;
          this.snackbar = true,
          this.snackbarText = 'An error occured, the passwords must be exactly the same.';
        }

      }

      if (valid == true) {

        if (this.editedIndex > -1) {

          axios.patch(`/api/users/${this.editedItem.id}`, this.editedItem)
          .then(res => {
            Object.assign(this.users[this.editedIndex], this.editedItem)
          });

        } else {

          axios.post(`/api/users`, this.editedItem)
          .then(response => {

            let users = Object.keys(response.data).map((k) => response.data[k])
            this.users.push(users[0])
          });

        }

        this.close()
      } 
      
    },
  },
}
</script>