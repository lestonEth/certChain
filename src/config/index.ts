import { cookieStorage, createStorage } from '@wagmi/core'
import { WagmiAdapter } from '@reown/appkit-adapter-wagmi'
import {
  mainnet,
  arbitrum,
  avalanche,
  base,
  optimism,
  polygon,
  type AppKitNetwork,
  baseSepolia
} from '@reown/appkit/networks'

export const projectId = '12f899790f0720dff5781c6aa4066677'

if (!projectId) {
  throw new Error('Project ID is not defined')
}

// Enhanced EduChain Testnet configuration
const eduChainTestnet = {
  id: 656476, // Verify this chain ID with EduChain documentation
  name: 'EDU Chain Testnet',
  nativeCurrency: {
    decimals: 18,
    name: 'EDU Coin',
    symbol: 'EDU',
  },
  rpcUrls: {
    default: {
      http: ['https://rpc.open-campus-codex.gelato.digital'],
    },
  },
  blockExplorers: {
    default: {
      name: 'EduScan Testnet',
      url: 'https://edu-chain-testnet.blockscout.com',  
    },
  },
  testnet: true, // Explicitly mark as testnet
  contracts: {
    // Add any required contracts if necessary
  },
} as const satisfies AppKitNetwork;

export const networks = [
  mainnet,
  arbitrum,
  avalanche,
  base,
  optimism,
  polygon,
  baseSepolia,
  eduChainTestnet, // Use updated variable name
] as [AppKitNetwork, ...AppKitNetwork[]];

export const wagmiAdapter = new WagmiAdapter({
  storage: createStorage({
    storage: cookieStorage
  }),
  ssr: true,
  networks,
  projectId
})

export const config = wagmiAdapter.wagmiConfig