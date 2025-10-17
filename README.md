## Publication Validator plugin

This plugin validates the article  mandatory metadata by various indexing and archiving services in the Open Journal Systems (OJS) platform.

This Plugin validates the article  mandatory metadata   for indexing in the following services:

| Service        | Supported             |
|----------------|-----------------------|
| DOAJ           | :heavy_check_mark:    |
| OpenAire       | :heavy_check_mark:    |

## Validated services
| Metadata Type        | DOAJ               | OpenAire            |
|----------------------|--------------------|---------------------|
| Title                | :heavy_check_mark: | :heavy_check_mark:  |
| DOI                  | :heavy_check_mark: | :heavy_check_mark:  |
| Publisher Institution| :heavy_check_mark: | :heavy_check_mark:  |
| License Condition    | :heavy_check_mark: |                     |
| Abstract             | :heavy_check_mark: | :heavy_check_mark:  |
| Access Rights        | :heavy_check_mark: | :heavy_check_mark:  |
| Subject              | :heavy_check_mark: | :heavy_check_mark:  |
| ISSN                 | :heavy_check_mark: | :heavy_check_mark:  |
| citations            | :heavy_check_mark: |                     |
| contributors         |                    | :heavy_check_mark:  |

### Supported OJS versions
- OJS 3.5

### Installation
```bash
cd $OJS/plugins/generic
git clone https://github.com/TIBHannover/metadataCheck.git # or download
git checkout stable-3_5_0 # branch
```
### Configuration
- Goto Website -> Plugins
- Search metadata check plugin under generic plugins
- Enable plugin
- Got to settings
- Enable services needed for validation

### Demo
- [Demo validation](https://github.com/user-attachments/assets/0e78757b-3f3b-4895-98b5-c38148bee54f)

### Troubleshooting
- Please file an [Issue](https://github.com/metadataCheck/metadataCheck/issues)


# Information
- This OJS plugin was developed by [TIB](https://tib.eu) under the European grant [CRAFT-OA](https://www.craft-oa.eu/).

