## Publication Validator plugin

This Plugin validates the article  mandatory metadata   for indexing in the following services:

| Service        | Supported             |
|----------------|-----------------------|
| DOAJ           | :heavy_check_mark:                  |
| OpenAire       | :construction_worker: |
| Web Of Science | :construction_worker: |



### Supported OJS versions
- OJS 3.3

### Installation
```bash
cd $OJS/plugins/generic
git clone https://github.com/withanage/publicationValidator.git # or download
git checkout -b stable-3_3_0 # branch
```
### Configuration
- Goto Website -> Plugins
- Search publication validator plugin under generic plugins
- Enable plugin
- Got to settings
- Enable services needed for validation

### Demo
- [Service Demo](https://github.com/ipula/publicationValidator/assets/21024487/bbe1a719-161e-4609-a220-f0c69cc40807)

### Troubleshooting
- Please file a [Issue](https://github.com/withanage/publicationValidator/issues)


# Information
- This OJS plugin was developed by [TIB](https://tib.eu) under the European grant [CRAFT-OA](https://www.craft-oa.eu/).

