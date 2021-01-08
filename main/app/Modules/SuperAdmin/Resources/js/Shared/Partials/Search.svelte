  <script>
  import { Inertia } from '@inertiajs/inertia';
	import { InertiaLink, page } from '@inertiajs/inertia-svelte';

    let searchQuery, searchResults, isSearching=false;

    let findProduct  = () =>{
      if (searchQuery.length < 2) {
        return;
      }

      Inertia.get(route($page.props.auth.user.user_type + '.multiaccess.products.find_product'), {
        q:searchQuery,
        search_key:'imei'
      },{
        only:['flash', 'errors'],
        onBefore: visit => isSearching = true,
        onSuccess: page => searchResults = page.props.flash.search_results,
        onFinish: () =>  isSearching = false
      })
    }

    let throttledSearch = _.debounce(findProduct, 500)

    let resetComponent = ()=>{
      jQuery.fancybox.close()
    }
  </script>

  <style lang="scss">
    .rui-search-body{
      max-height: 80vh;
      position: relative;
      min-height: 200px;

      .is-searching{
        display: block;
        position: absolute;
        max-height: 100vh;
        height: 100%;
        width: 100%;
        background: rgba($color: #000000, $alpha: 0.52);
        top: 0;
        left: 0;
        z-index: 10;
        color: white;

        .fa-spin{
          display: block;
          left: 50%;
          top: 50%;
          position: relative;
          font-size: 25px;
        }
      }
    }
  </style>

  <div class="rui-popup rui-popup-search container" id="search">
		<div class="rui-search">
			<div class="rui-search-head">
				<form action="#">
					<div class="input-group"><input type="search" class="form-control form-control-clean order-12" placeholder="Type to search..." bind:value="{searchQuery}" on:keypress="{() => {isSearching = true}}" on:input="{throttledSearch}">
						<div class="input-group-prepend mnl-3 order-1">
							<button type="button" class="btn btn-clean btn-uniform btn-grey-5 mb-0 mnl-10"><span data-feather="search" class="rui-icon rui-icon-stroke-1_5"></span></button>
						</div>
					</div>
				</form>
			</div>
			<div class="rui-search-body">
				<div class="row vertical-gap">
          {#if !searchResults}
            <div class="col-12">
              {#if !isSearching}
                <h4 class=" text-center text-danger">
                  Search product by IMEI or Serial No or Model No
                </h4>
              {/if}
            </div>
          {:else}
            <div class="col-12 pb-30">
              <h4>Products</h4>
              {#each searchResults as product}
                <InertiaLink href={route($page.props.auth.user.user_type + '.multiaccess.products.view_product_details', product.uuid)} class="media media-success" on:click="{resetComponent}">
                  <span class="media-img">
                    <img src="{product.img}" alt="">
                  </span>
                  <span class="media-body">
                    <span class="media-title">{product.color} {product.model} {product.storage_size}</span>
                    <small class="media-subtitle">{product.identifier}</small>
                  </span>
                </InertiaLink>
              {:else}
                <a href="#" class="media media-danger">
                  <span class="media-img">
                    <span>NA</span>
                  </span>
                  <span class="media-body">
                    <span class="media-title">No Products</span>
                    <small class="media-subtitle">There are no products matchng that imei</small>
                  </span>
                </a>
              {/each}
            </div>
          {/if}

					<!-- <div class="col-12 col-md-6 col-lg-4"><h4>Articles</h4>
						<a href="#" class="media"><span class="media-img">M</span> <span class="media-body"><span class="media-title">Minimal Design</span> <small class="media-subtitle">Be life tree every behold fish</small> </span></a>
						<a href="#" class="media"><span class="media-img"><span data-feather="heart" class="rui-icon rui-icon-stroke-1_5"></span></span> <span class="media-body"><span class="media-title">Admin Dashboard</span> <small class="media-subtitle">Fruit their us also rule one multiply</small> </span></a>
						<a href="#" class="media"><span class="media-img">R</span> <span class="media-body"><span class="media-title">Responsive Design</span> <small class="media-subtitle">Behold, to all own, one all fruitful let</small></span></a>
					</div>
					<div class="col-12 col-md-6 col-lg-4"><h4>Files</h4>
						<a href="#" class="media"><span class="media-img bg-transparent"><img src="./assets/images/icon-zip.svg" class="icon-file" alt=""></span><span class="media-body"><span class="media-title">Dashboard</span> <small class="media-subtitle">Admin &amp; Dashboard</small> </span></a>
						<a href="#" class="media"><span class="media-img bg-transparent"><img src="./assets/images/icon-jpg.svg" class="icon-file" alt=""></span><span class="media-body"><span class="media-title">Application</span> <small class="media-subtitle">Application</small> </span></a>
						<a href="#" class="media"><span class="media-img bg-transparent"><img src="./assets/images/icon-png.svg" class="icon-file" alt=""></span><span class="media-body"><span class="media-title">Marketing</span> <small class="media-subtitle">Landing &amp; Corporate</small></span></a>
					</div> -->

          {#if isSearching}
            <div class="is-searching">
              <i class="fa fa-spinner fa-spin"></i>
            </div>
          {/if}
				</div>
			</div>
		</div>
	</div>
