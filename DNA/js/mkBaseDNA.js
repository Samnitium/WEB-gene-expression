/*
	COLORI:

	Adenina		->		0xffff00	(Giallo)
	Timina		->		0xff00ff	(Viola)		/		Uracile		->		0x0000ff	(Blu)

	Citosina	->		0xff8000	(Arancione)
	Guanina		->		0x00ff00	(Verde)
	*/

	function generaBase(B, S){
		var base = new THREE.Object3D();
		base.position.set(0,0,0);

		var sphereGeometry = new THREE.SphereGeometry(1,24,24);
		var sphereMaterial = new THREE.MeshPhongMaterial({color: 0x0f00ff});
		var sphere = new THREE.Mesh(sphereGeometry,sphereMaterial);
		sphere.position.x = -6.9;
		sphere.material.opacity = .9;
		sphere.material.transparent = true;
		base.add(sphere);

		var cylinderGeometry = new THREE.CylinderGeometry( .2, .2, 6, 32 );
		switch (B){
			case "Adenina":
				var cylinderMaterial = new THREE.MeshPhongMaterial({color: 0xffff00});
				break;
			case "Timina":
				var cylinderMaterial = new THREE.MeshPhongMaterial({color: 0xff00ff});
				break;
			case "Citosina":
				var cylinderMaterial = new THREE.MeshPhongMaterial({color: 0xff8000});
				break;
			case "Guanina":
				var cylinderMaterial = new THREE.MeshPhongMaterial({color: 0x00ff00});
				break;
			case "Uracile":
				var cylinderMaterial = new THREE.MeshPhongMaterial({color: 0x0000ff});
				break;
		}
		var cylinder = new THREE.Mesh( cylinderGeometry, cylinderMaterial );
		cylinder.rotation.z = Math.PI/2;
		cylinder.position.set(3.9,0,0);
		cylinder.material.opacity = 1;
		cylinder.material.transparent = true;
		sphere.add(cylinder);

		if(S==="mirror")
			base.rotation.y = Math.PI;

		return base;
	}