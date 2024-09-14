<template>
  <v-data-table
      :headers="headers"
      :items="desserts"
      :error="error"
      sort-by="calories"
      class="elevation-1"
  >
    <template v-slot:item.num="{ index }">
      {{ index + 2 }}
    </template>
    <template v-slot:top>
      <v-toolbar
          flat
      >
        <v-toolbar-title>Tabela pojazdów</v-toolbar-title>
        <v-divider
            class="mx-4"
            inset
            vertical
        ></v-divider>

        <v-spacer></v-spacer>
        <v-dialog
            v-model="dialog"
            max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }">

            <v-btn
                color="primary"
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
            >
              Nowy pojazd
            </v-btn>

          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>
            <v-alert color="error" v-if="error" v-text="error"></v-alert>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                      cols="12"
                      sm="6"
                      md="4"
                  >
                    <v-text-field
                        v-model="editedItem.registration_number"
                        label="Numer rejestracyjny"
                    ></v-text-field>
                  </v-col>
                  <v-col
                      cols="12"
                      sm="10"
                      md="8"
                  >
                  <v-select
                      label="Select"
                      v-model="editedItem.model_id"
                      :items="models"
                      item-text="name"
                      item-value="id"
                  ></v-select>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                  color="blue darken-1"
                  text
                  @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                  color="blue darken-1"
                  text
                  @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Napewno chcesz usunąć ten pojazd?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
          small
          @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn
          color="primary"
          @click="initialize"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
</template>
<script>
import axios from 'axios';
export default {
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      { text: '1', value: 'num', sortable: false },
      {
        text: 'Numer rejestracyjny',
        align: 'start',
        sortable: true,
        value: 'registration_number',
      },
      { text: 'Marka', value: 'brand' },
      { text: 'Model', value: 'model' },
      { text: 'Data dodania', value: 'creation_date' },
      { text: 'Data utworzenia', value: 'modification_date' },
      { text: 'Actions', value: 'actions', sortable: false },
    ],
    error: '',
    desserts: [],
    models: [],
    editedIndex: -1,
    editedItem: {
      registration_number: '',
      models: null,
      id: 0,
    },
    defaultItem: {
      registration_number: '',
      models: null,
    },
  }),

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? 'Nowy pojazd' : 'Edytuj pojazd'
    },
  },

  watch: {
    dialog (val) {
      val || this.close()
    },
    dialogDelete (val) {
      val || this.closeDelete()
    },
  },

  created () {
    this.initialize();
  },

  methods: {
    initialize () {
      axios.get('/api/vehicles')
          .then(response => this.desserts = response.data.data)
          .catch(error => this.error ='problem with downloading data');
      axios.get('/api/models')
          .then(response => {this.models = response.data.data; })
          .catch(error => this.error ='problem with downloading data');
    },

    editItem (item) {
      this.error = '';
      this.editedIndex = this.desserts.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem (item) {
      this.editedIndex = this.desserts.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    deleteItemConfirm () {
      axios.delete('/api/vehicles/' + this.desserts[this.editedIndex].id)
          .then(response => {this.models = response.data; this.initialize();})
          .catch(error => this.error ='the vehicle could not be deleted');

      this.desserts.splice(this.editedIndex, 1)
      this.closeDelete()
    },

    close () {
      this.error = '';
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    closeDelete () {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    save () {
      if (this.editedIndex > -1) {
        axios.patch('/api/vehicles/' + this.desserts[this.editedIndex].id, {
          registrationNumber: this.editedItem.registration_number,
          model: this.editedItem.model_id
        }).then(response => {
          this.error = '';
          this.initialize()
          this.close()
        }).catch(error => {
          this.error = error.response.data.detail;
        });

      } else {
        axios.post('/api/vehicles', {
          registrationNumber: this.editedItem.registration_number,
          model: this.editedItem.model_id
        }).then(response => {
          this.error = '';
          this.initialize()
          this.close()
        }).catch(error => {
            this.error = error.response.data.detail;
        });
      }
    },
  },
}

</script>
