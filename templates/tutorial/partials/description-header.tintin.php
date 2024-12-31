%if($form_curriculum)
  <div class="container-fluid cirruculum-header-bg-color">
    <div class="container">
      <div class="row">
        %auth
          %include("curriculum.partials.progression")
        %endauth
      </div>
    </div>
  </div>
%endif
