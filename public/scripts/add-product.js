image.onchange = evt => {
    const [file] = image.files
    if (file) {
        selectedImage.src = URL.createObjectURL(file)
    }
  }