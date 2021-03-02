<script>
  export let title, appName, staffLocation;
</script>

<div class="rui-page-title">
  <div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href>{appName} - {staffLocation} branch </a>
        </li>
      </ol>
    </nav>
    <h1>{title}</h1>
  </div>
</div>
