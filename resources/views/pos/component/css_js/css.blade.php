<style>
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.modal.open {
  display: flex;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.modal-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.custom-text-center {
  text-align: center;
}

.custom-text-justify {
  text-align: justify;
}

@media (min-width: 1200px){
  .toggle-sidebar .sidebar {
    left: -500px;
  }
}
@media (min-width: 1200px){
  #main, #footer {
    margin-left: 500px;
  }
}

@media (max-width: 1199px){
  .sidebar {
    left: -500px;
  }
}
</style>
<!-- custom style -->