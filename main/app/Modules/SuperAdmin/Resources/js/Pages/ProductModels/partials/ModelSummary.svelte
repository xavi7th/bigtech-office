<script>
  export let name, imgUrl, category, brand;
</script>

<style lang="scss">
  .rui-profile-img {
    max-width: 100%;
    max-height: 350px;
    height: 350px;

    img {
      object-fit: contain;
      object-position: 50% 50%;
    }
  }
</style>

<div class="card">
  <div class="card-body">
    <div class="row vertical-gap">
      <div class="col-auto">
        <h3 class="rui-profile-info-title h4">{name}</h3>
        <div class="rui-profile-img">
          <img src={imgUrl} alt="" />
        </div>
      </div>
    </div>
    <div class="rui-profile-numbers">
      <div class="row justify-content-center">
        <div class="col" />
        <div class="col-auto">
          <div class="rui-profile-number text-center">
            <h4 class="rui-profile-number-title h2 text-capitalize">
              {category}
            </h4>
            <small class="text-grey-6">Category</small>
          </div>
        </div>
        <div class="col p-0" />
        <div class="col-auto">
          <div class="rui-profile-number text-center">
            <h4 class="rui-profile-number-title h2">{brand}</h4>
            <small class="text-grey-6">Brand</small>
          </div>
        </div>
        <div class="col" />
      </div>
    </div>
  </div>
</div>
