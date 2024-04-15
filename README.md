## Publication Validator plugin

This Plugin validates the article  mandatory metadata   for indexing in the following services:

| Service        | Supported             |
|----------------|-----------------------|
| DOAJ           | :heavy_check_mark:    |
| Web Of Science | :construction_worker: |


## Validated services
| Metadata Type      | DOAJ               | Web Of Science |
|--------------------|--------------------|-|
| Title              | :heavy_check_mark: | |
| DOI                | :heavy_check_mark: | |
| Publisher          | :heavy_check_mark: | |
| Language           | :heavy_check_mark: | |
| License Condition  | :x:                | |
| Abstract           | :heavy_check_mark: ||
| Author List        | :heavy_check_mark: | |
| Author Affiliation | :heavy_check_mark: | |
| Access Rights      | :x:                ||
| Subject            | :x:                | |
| ISSN               | :heavy_check_mark: | |

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
- [DOAJ validation](https://github.com/ipula/publicationValidator/assets/21024487/bbe1a719-161e-4609-a220-f0c69cc40807)

### Troubleshooting
- Please file an [Issue](https://github.com/withanage/publicationValidator/issues)


# Information
- This OJS plugin was developed by [TIB](https://tib.eu) under the European grant [CRAFT-OA](https://www.craft-oa.eu/).

