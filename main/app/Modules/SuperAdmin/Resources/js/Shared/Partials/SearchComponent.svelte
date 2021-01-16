  <script>
  import { Inertia } from '@inertiajs/inertia';
  import { createEventDispatcher } from 'svelte'
  const dispatch = createEventDispatcher()

  export let searchKeys={
        'imei': 'IMEI',
        'serial_no':'Serial No',
        'model_no':'Model No'
      }, dataKey;

    let searchQuery, searchKey;

    let performSearch  = () =>{
      if (searchQuery.length == 0) {
        resetData();
        return;
      }

      else if (searchQuery.length < 2) {
        return;
      }

      Inertia.reload({
        data: {
          searchQuery,
          searchKey
        },
        only:['flash', 'errors', dataKey],
        onBefore: visit => dispatch('isSearching', true),
        onFinish: () =>  dispatch('isSearching', false)
      })
    }

    let resetData = ()=>{
      Inertia.replace(route(route().current()), {
        onBefore: visit => dispatch('isSearching', true),
        onFinish: () =>  dispatch('isSearching', false)
      })
    }

    let throttledSearch = _.debounce(performSearch, 1000)
  </script>

  <div class="row">
    <div class="col-4 col-md-2">
      <select class="custom-select border-0" bind:value={searchKey}>
        {#each Object.entries(searchKeys) as [val, disp] }
          <option value="{val}">{disp}</option>
        {/each}
      </select>
    </div>
    <div class="col my-20">
      <div class="rui-search">
        <div class="rui-search-head">
          <form action="#">
            <div class="input-group">

              <div class="input-group-prepend mnl-3">
                <button type="button" class="btn btn-clean btn-uniform btn-grey-5 mb-0 mnl-10"><span data-feather="search" class="rui-icon rui-icon-stroke-1_5"></span></button>
              </div>
              <input type="search" class="form-control form-control-clean " placeholder="Type to search..." bind:value="{searchQuery}" on:keypress="{() => {dispatch('isSearching', true)}}" on:input="{throttledSearch}">
               <div class="input-group-append mnr-3">
                <!-- svelte-ignore missing-declaration -->
                <button type="button" class="btn btn-clean btn-uniform btn-grey-5 mb-0 mnl-10" on:click={resetData}><span data-feather="refresh-cw" class="rui-icon rui-icon-stroke-1_5"></span></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
