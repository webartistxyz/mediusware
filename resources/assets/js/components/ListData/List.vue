<template>
  <div>
    <div style="background-color: white; padding: 10px;">
      <div class="card">
        <div class="card-header">
          <slot name="list_header"></slot>
          <br />
          <div class="row">
            <div class="col-md-3">
              <div class="input-group mb-3">
                <select
                  id="select"
                  @change="perPgeQuery(url)"
                  class="form-control"
                  aria-describedby="basic-addon2"
                  v-model="query.per_page"
                >
                  <option
                    :value="5"
                    :selected="5 == query.per_page ? 'selected' : ''"
                    >5</option
                  >
                  <option
                    :value="10"
                    :selected="10 == query.per_page ? 'selected' : ''"
                    >10</option
                  >
                  <option
                    :value="25"
                    :selected="25 == query.per_page ? 'selected' : ''"
                    >25</option
                  >
                  <option
                    :value="50"
                    :selected="50 == query.per_page ? 'selected' : ''"
                    >50</option
                  >
                  <option
                    :value="100"
                    :selected="100 == query.per_page ? 'selected' : ''"
                    >100</option
                  >
                </select>
              </div>
            </div>
            <slot name="table_filters"></slot>
            <div class="col-md-3">
              <div class="input-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Search"
                  @input="perPgeQuerySearch(url)"
                  v-model="query.search"
                  aria-describedby="basic-addon2"
                />
              </div>
            </div>
            <div class="col-md-6" style="text-align: right;"></div>
          </div>
        </div>
        <!-- /.c  ard-header -->
        <div class="card-body" id="printMe">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" ref="mastu">
              <thead>
                <tr>
                  <th v-for="header in headers">
                    <div
                      :class="{
                        sort: header.sort,
                      }"
                      @click="sortBy(header)"
                    >
                      <span>{{ header.title }}</span>
                      <div v-if="header.sort" class="sort-direction">
                        <i
                          style="color: #d0e1e1;"
                          class="fa fa-sort"
                          v-if="header.name != query.sort_by"
                        ></i>
                        <i
                          class="fa fa-sort-amount-desc"
                          v-if="
                            header.name == query.sort_by &&
                            query.order_by == 'ASC'
                          "
                        ></i>
                        <i
                          class="fa fa-sort-amount-asc"
                          v-if="
                            header.name == query.sort_by &&
                            query.order_by == 'DESC'
                          "
                        ></i>
                      </div>
                    </div>
                  </th>
                </tr>
              </thead>

              <tbody v-if="dataList.length && defaultLoop">
                <tr v-for="(data, index) in dataList" :id="data.id">
                  <slot name="table_data" :data="data"></slot>
                </tr>
              </tbody>

              <tbody v-if="customLoop">
                <slot name="custom_loop_data"></slot>
              </tbody>
            </table>
            <div v-if="!dataList.length" class="text-center">
              <h5 style="color: #cc3300;">
                <b>No Results found!</b>
              </h5>
            </div>
          </div>
          <div class="flex_style" v-if="pagination">
            <div
              class="dataTables_info"
              id="example2_info"
              role="status"
              aria-live="polite"
            >
              Showing {{ paginator.from }} to {{ paginator.to }} of
              {{ paginator.total }} entries
            </div>
            <div
              class="dataTables_paginate paging_simple_numbers"
              id="example2_paginate"
            >
              <ul class="pagination">
                <li
                  :class="{
                    disabled: !paginator.first_page_url,
                  }"
                  class="paginate_button page-item previous"
                  id="example2_previous"
                >
                  <a
                    @click="
                      !paginator.first_page_url
                        ? null
                        : fatchPaginateData(paginator.first_page_url)
                    "
                    href="#"
                    class="page-link"
                    >«</a
                  >
                </li>
                <li
                  :class="{
                    disabled: !paginator.prev_page_url,
                  }"
                  class="paginate_button page-item previous"
                  id="example2_previous"
                >
                  <a
                    href="#"
                    class="page-link"
                    @click="
                      paginator.prev_page_url
                        ? fatchPaginateData(paginator.prev_page_url)
                        : null
                    "
                    >Previous</a
                  >
                </li>
                <li
                  class="paginate_button page-item"
                  v-for="(pageNumber, index) in paginator.last_page"
                  :key="pageNumber"
                  v-if="
                    Math.abs(pageNumber - currentPage) < 3 ||
                    pageNumber == paginator.last_page ||
                    pageNumber == 1
                  "
                  :class="{
                    active: currentPage === pageNumber,
                  }"
                >
                  <a
                    @click="
                      !paginator.path
                        ? null
                        : fatchPaginateData(
                            paginator.path + '?page=' + pageNumber
                          )
                    "
                    href="#"
                    class="page-link"
                  >
                    {{
                      pageNumber == paginator.last_page &&
                      Math.abs(pageNumber - currentPage) > 3
                        ? "..."
                        : null
                    }}
                    {{ pageNumber }}
                    {{
                      pageNumber == 1 && Math.abs(pageNumber - currentPage) > 3
                        ? "..."
                        : null
                    }}
                  </a>
                </li>
                <li
                  class="paginate_button page-item next"
                  :class="{
                    disabled: !paginator.next_page_url,
                  }"
                >
                  <a
                    @click="
                      !paginator.next_page_url
                        ? null
                        : fatchPaginateData(paginator.next_page_url)
                    "
                    href="#"
                    class="page-link"
                    >Next</a
                  >
                </li>
                <li
                  class="paginate_button page-item next"
                  id="example2_next"
                  :class="{
                    disabled: !paginator.last_page_url,
                  }"
                >
                  <a
                    href="#"
                    @click="
                      !paginator.last_page_url
                        ? null
                        : fatchPaginateData(paginator.last_page_url)
                    "
                    class="page-link"
                    >»</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div v-if="table_bottom_data">
          <br />
          <br />
          <slot name="table_bottom_data"></slot>
        </div>
      </div>
    </div>
    <template>
      <vue-topprogress ref="topProgress"></vue-topprogress>
    </template>
  </div>
</template>
<script>
import { vueTopprogress } from "vue-top-progress";
export default {
  name: "list_data",
  components: {},
  props: {
    url: {
      type: String,
      required: true,
    },
    tableSort: {
      type: String,
      required: true,
    },
    headers: {
      type: Array,
      required: true,
    },
    pagination: {
      type: Boolean,
      default: true,
    },
    search_bar: {
      type: Boolean,
      default: true,
    },
    table_style: {
      type: Boolean,
      default: true,
    },
    defaultLoop: {
      type: Boolean,
      default: true,
    },
    customLoop: {
      type: Boolean,
      default: false,
    },
    table_bottom_data: {
      type: Boolean,
      default: false,
    },
    others_query: {
      type: Object,
    },
  },
  data() {
    return {
      paginator: [],
      dataList: [],
      timeout: null,
      query: {
        search: "",
        sort_by: this.tableSort || "id",
        order_by: "DESC",
        per_page: 5,
        page: 1,
        pages: 0,
      },
      currentPage: 0,
      order_by: false,
      loader: false,
      errorMsz: null,
    };
  },
  methods: {
    sortBy(header) {
      if (!header.sort) {
        return;
      }
      this.order_by = !this.order_by;
      this.query.sort_by = header.name;

      if (this.order_by) {
        this.query.order_by = "ASC";
      }

      if (!this.order_by) {
        this.query.order_by = "DESC";
      }
      this.perPgeQuery(this.url);
    },
    makePagination(data) {
      let paginator = {
        current_page: data.current_page,
        last_page: data.last_page,
        next_page_url: data.next_page_url,
        prev_page_url: data.prev_page_url,
        first_page_url: data.first_page_url,
        last_page_url: data.last_page_url,
        from: data.from,
        to: data.to,
        total: data.total,
        path: data.path,
      };
      this.paginator = paginator;

      //console.log(paginator);
    },
    fatchPaginateData(url) {
      this.perPgeQuery(url);
    },
    async perPgeQuery(url) {
      this.loader = !this.loader;
      this.$refs.topProgress.start();
      try {
        const response = await axios.post(url, {
          per_page: this.query.per_page,
          search_term: this.query.search,
          sort_by: this.query.sort_by,
          order_by: this.query.order_by,
          others_query: this.others_query,
        });
        if (response) {
          // console.log(response);
          this.currentPage = response.data.current_page;
          this.dataList = response.data.data;
          this.loader = !this.loader;
          this.$refs.topProgress.done();
          this.makePagination(response.data);
        }
      } catch (error) {
        console.log(error);
      }
    },
    async perPgeQuerySearch(url) {
      clearTimeout(this.timeout);
      this.timeout = setTimeout(() => {
        this.perPgeQuery(url);
      }, 1000);
    },
  },
  mounted() {
    this.perPgeQuery(this.url);
  },
};
</script>
<style lang="scss" scoped>
.sort {
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
  &-direction {
    .fa {
      color: #838d94;
      font-size: 11px;
    }
  }
}
.table_fixed {
  overflow-y: auto;
  max-height: 500px;
}
.table_fixed th {
  position: sticky;
  top: 0;
  background: #f4f6f9;
}
.table_fixed::-webkit-scrollbar {
  display: none;
}
.table_fixed {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.flex_style {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
}
</style>
