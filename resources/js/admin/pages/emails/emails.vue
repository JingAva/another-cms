<template>
  <v-app dark="dark">
      <Navigation />
      <v-content app="app">
          <v-container class="pa-4" fluid="fluid" grid-list-md="grid-list-md">
              <v-layout wrap="wrap">
                  <v-flex xs12="xs12">
                      <h1 class="display-1 mb-1">Email Templates</h1>
                  </v-flex>
              </v-layout>
          </v-container>
          <v-data-table
            :headers="headers"
            :items="emails"
            sort-by="title"
            class="elevation-1"
            :loading="loading" 
            loading-text="Loading... Please wait"
            :search="search"
          >
            <template v-slot:top>
              <v-text-field v-model="search" label="Search" class="mx-4"></v-text-field>
              <v-toolbar flat color="white">
                <v-select
                :items="language"
                label="Language"
                v-model="selectedLanguage"
                @change="changeLanguage()"
                outlined
                ></v-select>
                <v-divider
                  class="mx-4"
                  inset
                  vertical
                ></v-divider>
                <div class="flex-grow-1"></div>
                <v-dialog v-model="dialog" max-width="1000px">
                  <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">New Template</v-btn>
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
                            <v-text-field v-model="editedItem.subject" label="Subject"></v-text-field>
                          </v-col>
                          <v-col cols="12" sm="6" md="12">
                            <text-editor v-model="editedItem.message" />
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

export default {
  components: {
    Navigation,
    TextEditor
  },
  data: () => ({
    language: [],
    languageData: [],
    selectedLanguage: '',
    selectedLanguageObject: [],
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
        value: 'title',
      },
      { text: 'Status', value: 'status_display' },
      { text: 'Actions', value: 'action', sortable: false },
    ],
    emails: [],
    editedIndex: -1,
    editedItem: {
      title: '',
      subject: '',
      message: '',
      language_id: '',
      language_code: '',
      language_name: '',
      status: '',
    },
    defaultItem: {
      title: '',
      subject: '',
      message: '',
      language_id: '',
      language_code: '',
      language_name: '',
      status: '',
    },
    show1: false,
    show2: false,
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'New Template' : 'Edit Template'
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

      this.initializeLanguageList();

    },
    initializeLanguageList () {

      axios.get('/api/languages')
            .then(response => {
          
          if (response.data) {
            let language = Object.keys(response.data).map((k) => response.data[k]);
            this.languageData = language[0];
            let initLanguage = '';
            this.languageData.forEach( (item, key) => {
                if (key == 0) {
                    initLanguage = item;
                }
                this.language.push(item.name);
            });
            this.selectedLanguageObject = initLanguage;
            this.selectedLanguage = initLanguage.name;
            this.initializeContent(initLanguage);
          }

      })
      .catch(response => {
          console.log(response);
      });

    },
    initializeContent(initLanguage) {

      axios.get('/api/email-templates')
            .then(response => {
          
        if (response.data) {
            let email = Object.keys(response.data).map((k) => response.data[k])
            
            email[0].forEach((item, key) => {

                if (item.language_id == initLanguage.id) {
                    this.emails.push(item);
                }

            });

            this.loading = false;
        }

      })
      .catch(response => {
          console.log(response);
      });

    },
    editItem (item) {
      this.editedIndex = this.emails.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      const index = this.emails.indexOf(item)

      if (confirm('Are you sure you want to delete this email template?')) {
        axios.delete(`/api/email-templates/${item.id}`)
        .then(res => this.emails.splice(index, 1));
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
        this.editedItem.status_display = 'Inactive';
      }

      let valid = true;
      if (isEmpty(this.editedItem.title)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a title.';
      }
      
      if (isEmpty(this.editedItem.subject)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a subject.';
      }
      
      if (isEmpty(this.editedItem.status)) {
        valid = false;
        this.snackbar = true,
        this.snackbarText = 'Please fill up a status.';
      }

      if (valid == true) {

        if (this.editedIndex > -1) {

          axios.patch(`/api/email-templates/${this.editedItem.id}`, this.editedItem)
          .then(response => {
            let emails = Object.keys(response.data).map((k) => response.data[k])
            Object.assign(this.emails[this.editedIndex], emails[0])
          });

        } else {

          this.editedItem.language_id = this.selectedLanguageObject.id;
          this.editedItem.language_code = this.selectedLanguageObject.code;
          this.editedItem.language_name = this.selectedLanguageObject.name;

          axios.post(`/api/email-templates`, this.editedItem)
          .then(response => {

            let emails = Object.keys(response.data).map((k) => response.data[k])
            this.emails.push(emails[0])
          });

        }

        this.close()
      } 
      
    },
    changeLanguage () {

        this.languageData.forEach( (item, index) => {
          if (item.name == this.selectedLanguage) {
            this.selectedLanguageObject = item;
          }
        });

        axios.get('/api/email-templates')
            .then(response => {
          
        if (response.data) {
            this.emails = [];
            let email = Object.keys(response.data).map((k) => response.data[k])
            
            email[0].forEach((item, key) => {

                if (item.language_name == this.selectedLanguage) {
                    this.emails.push(item);
                }

            });

            this.loading = false;
        }

      })
      .catch(response => {
          console.log(response);
      });

    }
  },
}
</script>