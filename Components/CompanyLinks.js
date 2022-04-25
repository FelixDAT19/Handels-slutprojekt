import {useRouter} from 'next/router'

function CompanyLinks({location}){ //maps out all locations where there is a company

    const router = useRouter();
    
    return location.map(({ id, companyId, mapLocation }, i) => {
        if (companyId !== null) {// will return an area position for the image
            return (
                   
                <area shape="rect" coords={mapLocation} alt={id} href={`/company/${companyId}`}/>     

            );
        }
    });
    

}
export default CompanyLinks;

