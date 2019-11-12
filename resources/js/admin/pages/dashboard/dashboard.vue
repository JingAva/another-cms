<template>
  <v-app dark="dark">
      <Navigation />
      <v-content app="app">
          <v-container class="pa-4" fluid="fluid" grid-list-md="grid-list-md">
              <v-layout wrap="wrap">
                  <v-flex xs12="xs12">
                      <h1 class="display-1 mb-1">Dashboard</h1>
                  </v-flex>
                  <v-flex xs12="xs12" md6="md6">
                      <v-layout wrap="wrap">
                          <v-flex v-for="(stat, index) in stats" xs6="xs6" :key="index">
                              <v-card class="text-xs-center" height="100%">
                                  <v-card-text>
                                      <div class="display-1 mb-2">{{ stat.number }}</div>{{ stat.label }}
                                  </v-card-text>
                              </v-card>
                          </v-flex>
                      </v-layout>
                  </v-flex>
                  <v-flex md6="md6">
                      <v-card height="100%">
                          <v-card-title class="blue lighten-4">Enquiries</v-card-title>
                          <v-data-table class="mt-1" :items="tasks"><template slot="items" slot-scope="props">
                                  <td>
                                      <v-checkbox @click="clickDeleteTask(props.item)"></v-checkbox>
                                  </td>
                                  <td>{{ props.item.title }}</td>
                              </template></v-data-table>
                      </v-card>
                  </v-flex>
                  <v-flex xs12="xs12">
                      <v-card>
                          <v-card-title class="blue lighten-4">New Enquiries<v-spacer></v-spacer>
                              <v-text-field v-model="newLeadsSearch" append-icon="search" label="Search"></v-text-field>
                          </v-card-title>
                          <v-data-table :headers="newLeadsHeaders" :items="newLeads" :search="newLeadsSearch"><template slot="items" slot-scope="props">
                                  <td>{{ props.item.firstName }} {{ props.item.lastName }}</td>
                                  <td>{{ props.item.email }}</td>
                                  <td>{{ props.item.company }}</td>
                              </template></v-data-table>
                      </v-card>
                  </v-flex>
              </v-layout>
          </v-container>
      </v-content>
  </v-app>
</template>

<script>
import Navigation from '../../components/navigation'

const stats = [
  {
    number: '42',
    label: 'New test this week',
  },
  {
    number: '500',
    label: 'New test this week',
  },
  {
    number: '233',
    label: 'New test this month',
  },
  {
    number: '$24,748',
    label: 'Sales this month',
  },
]

const tasks = [
  {
    id: 0,
    title: 'Book meeting for Thursday'
  },
  {
    id: 1,
    title: 'Review new leads'
  },
  {
    id: 2,
    title: 'Be awesome!'
  },
]

const newLeads = [
  {
    firstName: 'Giselbert',
    lastName: 'Hartness',
    email: 'ghartness0@mail.ru',
    company: 'Kling LLC',
  },
  {
    firstName: 'Honey',
    lastName: 'Allon',
    email: 'hallon1@epa.gov',
    company: 'Rogahn-Hermann',
  },
  {
    firstName: 'Tommy',
    lastName: 'Rickards',
    email: 'trickards2@timesonline.co.uk',
    company: 'Kreiger, Wehner and Lubowitz',
  },
  {
    firstName: 'Giffy',
    lastName: 'Farquharson',
    email: 'gfarquharson3@goo.gl',
    company: 'Heathcote-Funk',
  },
]

const newLeadsHeaders = [
  {
    text: 'Name',
    value: 'firstName',
  },
  {
    text: 'Email',
    value: 'email',
  },
  {
    text: 'Company',
    value: 'company',
  },
]

export default {
  components: {
    Navigation
  },
  data() {
    return {
      stats,
      tasks,
      newLeads,
      newLeadsHeaders,
      newLeadsSearch: '',
    }
  },
  methods: {
    clickDeleteTask(task) {
      const i = this.tasks.indexOf(task)
      this.tasks.splice(i, 1)
    },
  },
}
</script>