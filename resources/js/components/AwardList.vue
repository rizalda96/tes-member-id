<template>
  <div>
    <b-row class="d-flex justify-content-center mt-5">
      <b-col sm="8">
        <b-col sm="3" class="mb-2">
          <multiselect
            v-model="selected"
            :options="options"
            :multiple="true"
            :taggable="true"
            placeholder="Filter Type"
          ></multiselect>
          <div class="mt-2">
              0
              <input
                type="range"
                min="0"
                max="5000000"
                step="1"
                v-model="poin"
              >
              5.000.000
          </div>
          <div class="mt-1">
            <b-button
              type="button"
              variant="primary"
              @click="filterData"
            > Filter </b-button>
          </div>
        </b-col>
        <b-table
          id="award-list"
          striped
          hover
          :busy="isBusy"
          api-url="award.get"
          :items="loadProvider"
          show-empty
          :fields="fields"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          :filter="filter"
          :current-page="currentPage"
          :per-page="perPage"
        >
          <template v-slot:cell(type)="data">
            <b-badge :variant="variant(data.item)">{{ data.item.type }}</b-badge>
          </template>
          <template v-slot:cell(rownum)="data">
            <span class="no-wrap">{{ getRowNum(data.index) }}</span>
          </template>
          <template #table-busy>
            <div class="text-center text-danger my-2">
              <b-spinner class="align-middle"></b-spinner>
              <strong>Loading...</strong>
            </div>
          </template>
        </b-table>
        <div>
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
          ></b-pagination>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
  export default {
    name: 'award-list',
    data() {
      return {
        dari: 1,
        currentPage: 1,
        sortBy: 'created_at',
        sortDesc: true,
        perPage: 15,
        to: 0,
        totalRows: 0,
        isBusy: false,
        delay: 250,
        items: [],
        filter: null,
        fields: [
          {
            key: 'rownum',
            label: '#',
            class: 'text-center',
          },
          {
            key: 'name',
            label: 'Name',
            class: 'text-center',
            sortable: true,
          },
          {
            key: 'type',
            label: 'Type',
            class: 'text-center',
            sortable: true,
          },
          {
            key: 'poin',
            label: 'Poin',
            class: 'text-center',
            sortable: true,
          },
        ],
        options: [
          'Voucher',
          'Products',
          'Other',
        ],
        selected: null,
        poin: 0,
      }
    },
    methods: {
      getRowNum(idx) {
        return this.dari + idx
      },
      async loadProvider(ctx, callback) {
        let vm = this
        if (ctx.apiUrl) {
          let url = vm.$app.route(ctx.apiUrl)
          vm.isBusy = true
          vm.$http
            .get(url, {
              params: {
                page: ctx.currentPage,
                limit: ctx.perPage,
                sort_by: ctx.sortBy,
                sort_desc: ctx.sortDesc ? "desc" : "asc",
                search: ctx.filter,
              },
            })
            .then(output => {
              setTimeout(() => {
                let res = output.data
                let meta = ('meta' in output.data) ? output.data.meta : res;

                vm.isBusy = false
                vm.totalRows = meta.total
                vm.from = meta.from
                vm.to = meta.to
                callback(res.data || vm.items)
              }, vm.delay)
            })
            .catch(error => {
              vm.isBusy = false
              callback([])
            })
        } else {
          return vm.items || []
        }
      },
      variant(item) {
        if (item.type == 'voucher') return 'primary'
        if (item.type == 'products') return 'warning'
        return 'secondary'
      },
      filterData() {
        this.filter = {
          selected: this.selected,
          poin: this.poin,
        }
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>

