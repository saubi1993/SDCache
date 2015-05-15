<?php
namespace InitializeCache;
use InitializeCache\SDCacheConstants;

	class template{
		function templatestring($new_service) {
		
	        $template_string= <<<cmd

{
{{range \$tag, \$services := service "$new_service" | byTag}}
 "{{\$tag}}" : [
{{range \$services}} {
						"id"       : "{{.ID}}" ,
						"name"     : "{{.Name}}" ,
						"ip"       : "{{.Address}}" ,
						"port"     : "{{.Port}}" ,
						"tag"      : "{{\$tag}}",
						"hostname" : "{{.Node}}",{{range ls  .ID }}
						"{{.Key}}" : {{.Value}},{{end}}},{{end}}],{{end}}}

cmd;
			//print_r($template_string);
	        file_put_contents(SDCacheConstants::TEMPLATE_PATH.$new_service.".ctmpl", $template_string);
	        }
    }