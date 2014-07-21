function createTexture(geom, imageFile, bump) {
		var texture = THREE.ImageUtils.loadTexture("assets/textures/general/" + imageFile)
		var mat = new THREE.MeshPhongMaterial();
		mat.map = texture;
		if (bump) {
    		var bump = THREE.ImageUtils.loadTexture("assets/textures/general/" + bump);
       		mat.bumpMap = bump;
        	mat.bumpScale = 0.5;
    	}
		var mesh = new THREE.Mesh(geom, mat);
		return mesh;
    }