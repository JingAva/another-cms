<template>
  <v-app dark="dark">
      <Navigation />
      <v-content app="app">
          <v-container class="pa-4" fluid="fluid" grid-list-md="grid-list-md">
              <v-layout wrap="wrap">
                  <v-flex xs12="xs12">
                      <h1 class="display-1 mb-1">Pages</h1>
                  </v-flex>
              </v-layout>
          </v-container>
          <v-data-table
            :headers="headers"
            :items="pages"
            sort-by="title"
            class="elevation-1"
            :loading="loading" 
            loading-text="Loading... Please wait"
            :search="search"
          >
            <template v-slot:top>
              <v-text-field v-model="search" label="Search" class="mx-4"></v-text-field>
              <v-toolbar flat color="white">
                <v-toolbar-title>Page</v-toolbar-title>
                <div class="flex-grow-1"></div>
                <v-dialog v-model="dialog" max-width="1000px">
                  <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">New Page</v-btn>
                  </template>
                  <v-card>
                    <v-card-title>
                      <span class="headline">{{ formTitle }}</span>
                    </v-card-title>
                    <v-card-text>
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="6" md="12">
                            <v-text-field v-model="editedItem.title" label="Title"></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-text-field v-model="editedItem.description" label="Description"></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <v-radio-group v-model="editedItem.status">
                              <v-radio
                                :label="`Active`"
                                :value="1"
                              ></v-radio>
                              <v-radio
                                :label="`Inactive`"
                                :value="0"
                              ></v-radio>
                            </v-radio-group>
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
import TextEditor from '../../components/editor.vue';
import Sortable from 'sortablejs';

export default {
  components: {
    Navigation,
    TextEditor
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
        text: 'Title',
        align: 'left',
        sortable: false,
        value: 'name',
      },
      { text: 'Status', value: 'status' },
      { text: 'Actions', value: 'action', sortable: true },
    ],
    pages: [],
    editedIndex: -1,
    editedItem: {
      title: '',
      description: '',
      status: '',
    },
    defaultItem: {
      title: '',
      description: '',
      status: '',
    },
    show1: false,
    show2: false,
    domain: '',
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Page' : 'Edit Page'
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

  mounted() {
    let table = document.querySelector(".v-data-table tbody");
    const _self = this;
    Sortable.create(table, {
      onEnd({ newIndex, oldIndex}) {
        const rowSelected = _self.desserts.splice(oldIndex, 1)[0];
        _self.desserts.splice(newIndex, 0, rowSelected);
      }
    })
  },

  methods: {
    initialize() {

      axios.get('/api/page')
            .then(response => {
          
        if (response.data) {
            let page = Object.keys(response.data).map((k) => response.data[k])
            this.pages = page[0];
            this.loading = false;
        }

      })
      .catch(response => {
          console.log(response);
      });

    },
    editItem (item) {
      this.editedIndex = this.pages.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      const index = this.pages.indexOf(item)

      if (confirm('Are you sure you want to delete this page?')) {
        axios.delete(`/api/page/${item.id}`)
        .then(res => this.pages.splice(index, 1));
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
      if (isEmpty(this.editedItem.title)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a title.';
      }
      
      if (isEmpty(this.editedItem.status)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a status.';
      }

      if (valid == true) {

        if (this.editedIndex > -1) {

          axios.patch(`/api/page/${this.editedItem.id}`, this.editedItem)
          .then(response => {
            let pages = Object.keys(response.data).map((k) => response.data[k])
            Object.assign(this.pages[this.editedIndex], pages[0])
          });

        } else {

          axios.post(`/api/page`, this.editedItem)
          .then(response => {

            let pages = Object.keys(response.data).map((k) => response.data[k])
            this.pages.push(pages[0])
          });

        }

        this.close()
      } 
      
    },
    manageItem() {
      console.log('asdad');
    },
  },
}
</script>