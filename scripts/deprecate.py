from ruamel.yaml import YAML

yaml = YAML()
yaml.preserve_quotes = True
yaml.width = 4096
yaml.indent(mapping=2, sequence=4, offset=2)

with open('/work/res/fingerprint-server-api.yaml', 'r') as f:
    data = yaml.load(f)

for schema in data['components']['schemas'].values():
    schema['deprecated'] = True

data['components']['schemas']['Integration']['properties']['subintegration']['deprecated'] = True

with open('/work/res/fingerprint-server-api.yaml', 'w') as f:
    yaml.dump(data, f)

print("Done.")